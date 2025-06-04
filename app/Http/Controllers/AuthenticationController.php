<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticationController extends Controller
{
    // begin login 
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'name' => ['required'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('login')->with('Failed', 'Check your credentials');
        }

        $user = Auth::user();
        $token = $user->createToken('auth_token')->accessToken;
        $user->update([
            'remember_token' => $token,
            'updated_at' => now()
        ]);
        return response()->json(['token' => $token]);
    }
    // end login

    // begin logout
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json(['message' => 'Successfully logged out']);
    }
}
