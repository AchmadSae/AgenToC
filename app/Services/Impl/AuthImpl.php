<?php

namespace App\Services\Impl;

use App\Helpers\Constant;
use App\Services\AuthInterface;
use App\Models\User;
use App\Models\UserDetailModel;
use App\Helpers\GenerateId;
use App\Helpers\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;
use Illuminate\Cache\RateLimiter;
use Illuminate\Auth\Events\Lockout;
use Throwable;


class AuthImpl implements AuthInterface
{

    public function hasVerifiedEmail($email): bool
    {
        $response = false;
        $isExistVerified = User::where('email', $email)
            ->exists();
        if ($isExistVerified) {
            $response = true;
        }
        return $response;
    }

    public function login($data): bool
    {
        $hasRole = DB::table('user_detail_roles')
            ->join('roles', 'roles.role_id', '=', 'user_detail_roles.role_id')
            ->where('user_detail_roles.user_detail_id', $data->user_detail_id)
            ->where('roles.role_name', $data->role_name)
            ->where('user_detail_roles.is_active', true)
            ->exists();
        Log::browser($data, 'Service Login User');

        $hasVerified = $this->hasVerifiedEmail($data->email);
        if (!$hasRole && !$hasVerified) {
            return false;
        }
        return true;
    }

      /**
       * @throws Throwable
       */
      public function register($data, $isGoogleAuth = false): array
    {
        #local $user_Detail_id for prevent duplicate id
        $user_detail_id = GenerateId::generateId('UD', true);
        $role_id = match ($data->role) {
            'admin' => Constant::ROLE_ADMIN,
            'worker' => Constant::ROLE_WORKER,
            default => Constant::ROLE_CLIENT,
        };
        #debug
        Log::browser($data, 'Register User role: ' . $role_id);
        #check email isUnique
          if(!$isGoogleAuth) {
              $user = User::where('email', $data->email)->first();
              if ($user) {
                  return [
                        'user_detail_id' => $user->user_detail_id,
                      'message' => 'Your email and username is already registered.',
                        'success' => false,
                  ];
              }
          }

        $response = DB::transaction(function () use ($user_detail_id, $role_id, $data, &$registeredUser, $isGoogleAuth) {
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
                  'is_active' => $isGoogleAuth,
            ]);
            if (!$isGoogleAuth) {
                # code...
                $registeredUser->sendEmailVerificationNotification();
            }
            #check isFromTransaction
            return $registeredUser;
        }, Constant::DB_ATTEMPT);
        return [
            'flag' => $data->role,
            'user_detail_id' => $response->user_detail_id,
            'message' => 'Successfully registered! Confirm email to activate your account.',
              'success' => true,
        ];
    }

    public function forgotPassword($data): bool
    {
        return true;
    }

    #on test
    public function reset($data): bool
    {
          return Password::reset(
              $data->only('email', 'password', 'password_confirmation', 'token'),
              function (User $user, string $password) {
                  $user->forceFill([
                      'password' => Hash::make($password),
                  ])->setRememberToken(Str::random(60));

                  $user->save();

                  event(new PasswordReset($user));
              }
          );
    }

    #on test
    public function ensureIsNotRateLimited($data)
    {
        $limiter = app(RateLimiter::class);
        $key = $this->throttleKey($data->email);
        if ($limiter->tooManyAttempts($key, Constant::MAX_ATTEMPTS)) {
            $seconds = $limiter->availableIn($key);
            event(new Lockout($data));
        }

        throw ValidationException::withMessages([
            'email' => __('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    public function throttleKey($email): string
    {
        return Str::transliterate(Str::lower($email) . '|' . request()->ip());
    }

      /**
       * @throws Throwable
       */
      public function authGoogle($googleUser): array
      {
            $data = [
                  'username' => $googleUser->name,
                  'email' => $googleUser->email,
                  'profile' => $googleUser->avatar,
            ];
            $isSigned = User::where('google_id', $googleUser->id)->exists();
            #insert
            if ($isSigned) {
                  return [
                        'isSigned' => true,
                        'success' => false,
                  ];
            }
            return $this->register($data, true);
      }
}
