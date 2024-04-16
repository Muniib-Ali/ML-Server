<?php

namespace App\Http\Controllers;

use App\Rules\UserActivated;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email', new UserActivated],
            'password' => ['required'],
        ]);
        

    
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            // Authentication passed...
            $authstatus = Auth::user();
            $user = $authstatus->is_admin;
            if($user){
                return redirect()->intended('/requests');

            } else {
                return redirect()->intended('/');

            }
        } else {
            return redirect()->back()->withErrors(['error' => 'Email or Password are incorrect']);
        }
    }

    public function showResetPage()
    {
    
        return view('password-reset-request');

    }

    public function sendPasswordResetEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? redirect()->back()->with('success', 'If an account with that email exists, a reset email has been sent!'):
            redirect()->back()->with('success', 'If an account with that email exists, a reset email has been sent!');
    }
}
