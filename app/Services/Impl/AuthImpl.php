<?php

namespace App\Services\Impl;

use App\Helpers\Constant;
use App\Services\AuthInterface;
use App\Models\User;
use App\Models\UserDetailModel;
use App\Helpers\GenerateId;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;
#please check function ratelimiter
use Illuminate\Cache\RateLimiter;
use Illuminate\Auth\Events\Lockout;




class AuthImpl implements AuthInterface
{


    public function __construct()
    {

    }

    public function login($data): bool
    {
        $hasRole = DB::table('user_detail_roles')
            ->join('roles', 'roles.role_id', '=', 'user_detail_roles.role_id')
            ->where('user_detail_roles.user_detail_id', $data->user_detail_id)
            ->where('roles.role_name', $data->role_name)
            ->where('user_detail_roles.is_active', true)
            ->exists();
        $hasVerified = $data->hasVerifiedEmail();
        if (!$hasRole && !$hasVerified) {
            return false;
        }
        return true;
    }

    public function register($data): array
    {
        #local $user_Detail_id for prevent duplicate id
        $user_detail_id = GenerateId::generateWithDate('UD');
        $registeredUser = [];
        $role_id = match ($data->role) {
            'admin' => Constant::ROLE_ADMIN,
            'worker' => Constant::ROLE_WORKER,
            default => Constant::ROLE_CLIENT,
        };
        #check email isUnique
        $user = User::where('email', $data->email)->first();
        if ($user) {
            return [
                'message' => 'Your email and username is already registered.',
            ];
        }

        DB::transaction(function () use ($user_detail_id, $role_id, $data, &$registeredUser) {
            //code...
            $user_detail = UserDetailModel::create([
                'id' => $user_detail_id,
                'skills' => $data->skill,
                'tag_line' => $data->tagline,
            ]);
            $registeredUser = User::create([
                'user_detail_id' => $user_detail->id,
                'name' => $data->name,
                'email' => $data->email,
                'password' => Hash::make($data->password)
            ]);

            DB::table('user_detail_roles')->insert([
                'user_detail_id' => $user_detail->id,
                'role_id' => $role_id,
            ]);
            $registeredUser->sendEmailVerificationNotification();
            return $registeredUser;

        }, 5);
        return [
            'flag' => $data->flag,
            'user' => $registeredUser,
            'message' => 'Successfully registered! Confirm email to activate your account.',
        ];
    }

    public function forgotPassword($data): bool
    {
        return true;
    }

    #on test
    public function reset($data): bool
    {
        $status = Password::reset(
            $data->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );
        return $status;
    }

    #on test
    public function ensureIsNotRateLimited($data)
    {
        if (!RateLimiter::tooManyAttempts($this->throttleKey($data->email), 5)) {
            return;
        }

        event(new Lockout(request()));

        $seconds = RateLimiter::availableIn($this->throttleKey($data->email));

        throw ValidationException::withMessages([
            'email' => __('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    public function throttleKey($email)
    {
        return Str::transliterate(Str::lower($email) . '|' . request()->ip());
    }
}