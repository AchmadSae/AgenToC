<?php

namespace App\Http\Controllers;

use App\Helpers\GenerateId;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Auth\Events\Verified;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB;
use App\Models\UserDetailModel;
use RealRashid\SweetAlert\Facades\Alert as SweetAlert;

class AuthController extends Controller
{
    public function showLoginForm($flag)
    {
        if (!$flag == 'user') {
            return view('auth.login', ['flag' => $flag]);
        }

        return view('auth.login', ['flag' => $flag]);
    }


    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $user = User::where('email', $credentials['email'])->first();

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            try {
                $hasRole = DB::table('user_detail_roles')
                    ->join('roles', 'roles.role_id', '=', 'user_detail_roles.role_id')
                    ->where('user_detail_roles.user_detail_id', $user->user_detail_id)
                    ->where('roles.role_name', $request->role_name)
                    ->where('user_detail_roles.is_active', true)
                    ->exists();
                $hasVerified = $user->hasVerifiedEmail();
                if (!$hasRole && !$hasVerified) {
                    Auth::logout();
                    throw ValidationException::withMessages([
                        'role' => 'You do not have access to this role or account is not verified.',
                    ]);
                }
            } catch (QueryException $e) {
                return back()->withErrors([
                    'error' => 'Ups! something went wrong!' . $e->getMessage(),
                ]);
            }

            // dd($request->role_name);
            return match ($request->role_name) {
                'admin' => redirect()->route('admin_dashboard'),
                'user' => redirect()->route('client_dashboard'),
                'worker' => redirect()->route('worker_dashboard'),
                default => redirect()->route('home'),
            };
        }

        return back()->withErrors([
            'email' => 'Email or password is incorrect.',
        ])->onlyInput('email');
    }
    public function showRegistrationForm($flag)
    {
        if (!$flag == 'User') {
            return view('auth.register', ['flag' => $flag]);
        }

        return view('auth.register', ['flag' => $flag]);
    }

    public function register(Request $request)
    {
        $user_detail_id = GenerateId::generateWithDate('UD');
        $role_id = match ($request->role) {
            'admin' => 'RADMIN',
            'worker' => 'RWORKER',
            default => 'RUSER',
        };

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed'],
            'skill' => ['string'],
            'tagline' => ['string'],
        ]);


        /**
         * check if email and name is unique in DB
         **/

        $user = User::where('email', $request->email)->first();
        if ($user) {
            throw ValidationException::withMessages([
                'info' => 'Your email and username is already registered.',
            ]);
        }

        try {
            //code...
            $user_detail = UserDetailModel::create([
                'id' => $user_detail_id,
                'skills' => $request->skill,
                'tag_line' => $request->tagline,
            ]);
            $user = User::create([
                'user_detail_id' => $user_detail->id,
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ]);

            DB::table('user_detail_roles')->insert([
                'user_detail_id' => $user_detail->id,
                'role_id' => $role_id,
            ]);
            $user->sendEmailVerificationNotification();
            SweetAlert::success('success', 'Successfully registered! Confirm email to activate your account.');
            return redirect()->route('sign-in', ['flag' => $request->role_name]);
        } catch (\Throwable $th) {
            return back()->withErrors([
                'info' => "Error! Please notify admin." . $th->getMessage(),
            ]);
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        $request->session()->flush();

        SweetAlert::success('success', 'Successfully logged out!');
        return redirect('/');
    }

    // Email verification
    public function verifyEmail(Request $request, $id, $hash)
    {
        $user = User::findOrFail($id);

        if (!hash_equals((string) $hash, sha1($user->getEmailForVerification()))) {
            abort(403);
        }

        if ($user->hasVerifiedEmail()) {
            SweetAlert::info('info', 'Email already verified!');
            return redirect()->route('sign-in', ['flag' => 'user']);
        }

        $user->markEmailAsVerified();
        event(new Verified($user));
        SweetAlert::success('success', 'Successfully verified!');
        return redirect('/');
    }

    public function resendVerification(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect('/');
        }
        $request->user()->sendEmailVerificationNotification();
        SweetAlert::success('info', 'Verification link sent!');
        return back();
    }

    // Password reset
    public function showLinkRequestForm()
    {
        return view('auth.passwords.email'); // Buat view email.blade.php
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status == Password::RESET_LINK_SENT
            ? back()->with('status', __($status))
            : back()->withErrors(['email' => __($status)]);
    }

    public function showResetForm($token)
    {
        return view('auth.passwords.reset', ['token' => $token]);
    }

    public function reset(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        return $status == Password::PASSWORD_RESET
            ? redirect()->route('login')->with('status', __($status))
            : back()->withErrors(['email' => [__($status)]]);
    }

    /**
     * Ensure the authentication request is not rate limited.
     */
    protected function ensureIsNotRateLimited(): void
    {
        if (!RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout(request()));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => __('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the authentication rate limiting throttle key.
     */
    protected function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->email) . '|' . request()->ip());
    }
}
