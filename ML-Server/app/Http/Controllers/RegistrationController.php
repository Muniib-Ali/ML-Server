<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegistrationController extends Controller
{
    public function registrate(Request $request){

        $this->validate($request, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'max:255', 'email', 'unique:users'],
            'slack' => ['required', 'string', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'confirmed']
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'slack' => $request->slack,
            'password' => Hash::make($request->password),
            'credits' => 500
        ]);
        
        $credentials = $request->only('slack', 'password');
 
        if (Auth::attempt($credentials)) {
            // Authentication passed...
            return redirect()->intended('/admin');
        }

    }
}
