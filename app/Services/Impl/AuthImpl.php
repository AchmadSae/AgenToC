<?php

namespace App\Services\Impl;

use App\Helpers\Constant;
use App\Notifications\CustomVerifyEmail;
use App\Services\AuthInterface;
use App\Models\User;
use App\Models\UserDetailModel;
use App\Helpers\GenerateId;
use App\Helpers\LogConsole;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;
use Illuminate\Cache\RateLimiter;
use Illuminate\Auth\Events\Lockout;
use Symfony\Component\CssSelector\Exception\InternalErrorException;


class AuthImpl implements AuthInterface
{

    public function hasVerifiedEmail($email): bool
    {
          return User::where('email', $email)
                ->where('email_verified_at', '!=', null)
                ->exists();
    }

    public function login($data): bool
    {
          try {
                $hasRole = DB::table('user_detail_roles')
                      ->join('roles', 'roles.role_id', '=', 'user_detail_roles.role_id')
                      ->where('user_detail_roles.user_detail_id', $data->user_detail_id)
                      ->where('roles.role_name', $data->role_name)
                      ->where('user_detail_roles.is_active', true)
                      ->exists();
                Log::info('AuthController.login hasRole: ' . $hasRole);
                $hasVerified = $this->hasVerifiedEmail($data->email);
                if (!$hasRole && !$hasVerified) {
                      return false;
                }
                return true;
          } catch (ModelNotFoundException $th) {
                Log::error('AuthController.login ModelNotFoundException: ' . $th->getMessage());
          }
          return false;
    }

      /**
       * @throws \Throwable
       */
      public function register($data, $isTransaction = false): array
    {
          Log::info('Begin AuthImpl.register() call'. json_encode($data));
          #check email isUnique
          $user = User::where('email', $data['email'])->exists();
          if ($user) {
                return [
                      'user' => null,
                      'status' => false,
                      'message' => 'Your email and username is already registered.',
                ];
          }
          LogConsole::browser($data, 'Begin AuthImpl.register() call');
          #local $user_Detail_id for prevent duplicate id
        $user_detail_id = GenerateId::generateId('UD', true);
        $role_id = match ($data['role']) {
            'admin' => Constant::ROLE_ADMIN,
            'worker' => Constant::ROLE_WORKER,
            default => Constant::ROLE_CLIENT,
        };
        #debug
        LogConsole::browser($data, 'Register User role: ' . $role_id);

        try{
              DB::beginTransaction();
                    //code...
                    $userDetail = UserDetailModel::create([
                          'id' => $user_detail_id,
                          'skills' => $data['skills'],
                          'tag_line' => $data['tag_line'],
                          'credit_number' => $data['card_number'],
                    ]);

                    $registeredUser = User::create([
                          'user_detail_id' => $userDetail->id,
                          'name' => $data['name'],
                          'email' => $data['email'],
                          'password' => Hash::make($data['password'])
                    ]);

                    $userDetailRoles = DB::table('user_detail_roles')->insert([
                          'user_detail_id' => $userDetail->id,
                          'role_id' => $role_id,
                          'is_active' => $isTransaction
                    ]);
                    #debug
              LogConsole::browser('after db insert',  $registeredUser);
                    #check isFromTransaction
                    if (!$isTransaction) {
                          $dataUser = [
                                'name' => $registeredUser->name,
                                'email' => $registeredUser->email,
                                'password' => $registeredUser->password,
                                'role' => $role_id
                          ];
                          $registeredUser->notify(new CustomVerifyEmail($dataUser));
                    }
              $status = $registeredUser && $user_detail_id && $userDetailRoles;
        }catch(\Throwable $e){
              DB::rollBack();
              Log::error('AuthImpl.register() error: ' . $e->getMessage());
            throw new InternalErrorException("DB transaction failed :".$e->getMessage());
        }
        if (!$status) {
              DB::rollBack();
              Log::warning('AuthImpl.register() error: DB transaction status false');
              throw new InternalErrorException("DB transaction status : false");
        }
        DB::commit();
        return [
              'status' => true,
              'message' => 'User register Success',
              'user' => $registeredUser
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

    public function throttleKey($email)
    {
        return Str::transliterate(Str::lower($email) . '|' . request()->ip());
    }

      public function deleteRelatedUser($userDetailId): bool
      {
           try {
                 DB::beginTransaction();
                 $user = User::where('user_detail_id', $userDetailId)->delete();
                 $userDetail = UserDetailModel::where('id', $userDetailId)->delete();
                 $userDetailRoles = DB::table('user_detail_roles')->where('user_detail_id', $userDetailId)->delete();
                 $status = $user && $userDetail && $userDetailRoles;
                 DB::commit();
                 return $status;
           }catch (\Throwable $th) {
                 return false;
           }
      }
}
