<?php

namespace App\Http\Controllers;

use App\Helpers\Log;
use App\Models\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Random\RandomException;
use RealRashid\SweetAlert\Facades\Alert;
use App\Services\AuthInterface;
use Illuminate\Auth\Notifications\ResetPassword;
use Symfony\Component\CssSelector\Exception\InternalErrorException;
use TheSeer\Tokenizer\Token;

class AuthController extends Controller
{
    protected AuthInterface $authInterface;
    public function showLoginForm($flag)
    {
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
                Alert::error('error', 'Ups! you are not allowed to login'); // If the login attempt was unsuccessful, redirect back with an error message
                return back();
            }
            return match ($request->role) {
                'admin' => redirect()->route('admin_dashboard'),
                'user' => redirect()->route('client_dashboard'),
                'worker' => redirect()->route('worker_dashboard'),
                default => redirect()->route('home'),
            };
        }

        Alert::error('error', 'Ups! password or email is incorrect'); // If the login attempt was unsuccessful, redirect back with an error message
        return back();
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
        log::browser($request, 'Register User');
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed'],
            'role' => ['required'],
        ]);
        try {
            //code...
            $response = $this->authInterface->register($request);
            Alert::success('success', $response['message']);
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

        Alert::success('success', 'Successfully logged out!');
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
            Alert::info('info', 'Email already verified!');
            return redirect()->route('sign-in', ['flag' => 'user']);
        }

        $user->markEmailAsVerified();
        event(new Verified($user));
        Alert::success('success', 'Successfully verified!');
        return redirect('/');
    }

    public function resendVerification(Request $request)
    {
    }

    // Password reset
    public function showLinkRequestForm(Request $request)
    {

    }

    public function sendResetLinkEmail(Request $request)
    {
          $request->validate(['email' => 'required|email']);

          $status = Password::sendResetLink($request->only('email'));

          return $status == Password::RESET_LINK_SENT
                ? back()->with('success', 'email sent')
                : back()->withErrors(['email' => __($status)]);

    }

    public function showRequestForm()
    {
          return view('auth.password.reset_password_email');

    }

      /**
       * @throws RandomException
       */
      public function showResetForm()
    {
          $token = bin2hex(random_bytes(20));
          return view('auth.password.form_reset_password_email', ['token' => $token]);
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
