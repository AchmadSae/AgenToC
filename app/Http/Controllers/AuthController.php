<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use RealRashid\SweetAlert\Facades\Alert as SweetAlert;
use App\Services\AuthInterface;
use Symfony\Component\CssSelector\Exception\InternalErrorException;

class AuthController extends Controller
{
    protected $authInterface;
    public function __construct(AuthInterface $authInterface)
    {
        $this->authInterface = $authInterface;
    }

    public function showLoginForm($flag)
    {
        if (!$flag == 'user') {
            return view('auth.login', ['flag' => $flag]);
        }

        return view('auth.login', ['flag' => $flag]);
    }


    public function login(Request $request)
    {
        $response = false;
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            try {
                #call the service
                $response = $this->authInterface->login($request);

            } catch (QueryException $e) {
                return back()->withErrors([
                    'error' => 'Ups! something went wrong!' . $e->getMessage(),
                ]);
            }

            if (!$response) {
                return back()->withErrors([
                    'error' => 'Role Access Denied!',
                ]);
            }
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
        $response = [];
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed'],
            'skill' => ['string'],
            'tagline' => ['string'],
            'role' => ['required'],
        ]);
        try {
            //code...
            $response = $this->authInterface->register($data);
            SweetAlert::success('success', $response['message']);
            return redirect()->route('sign-in', ['flag' => $response['flag']]);
        } catch (InternalErrorException $th) {
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
        $response = false;
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8',
        ]);

        try {
            $response = $this->authInterface->reset($request);
        } catch (InternalErrorException $th) {
            return back()->withErrors([
                'info' => "Ups! something went wrong!" . $th->getMessage(),
            ]);
        }
        return $response == Password::PASSWORD_RESET
            ? redirect()->route('login')->with('status', __($response))
            : back()->withErrors(['email' => [__($response)]]);
    }

}
