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
            'notes' => ['max:255'],
            'password' => ['required', 'string', 'min:8' ,'confirmed']
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'slack' => $request->slack,
            'notes' => $request->notes,
            'password' => Hash::make($request->password),
            'credits' => 3500
        ]);
        
        return redirect()->back()->with('success', 'Registration was successful, please wait for admins to activate your account!');
        /*
        $credentials = $request->only('slack', 'password');

        if (Auth::attempt($credentials)) {
            // Authentication passed...
            $authstatus = Auth::user();
            $user = $authstatus->is_admin;
            if($user){
                return redirect()->intended('/requests');

            } else {
                return redirect()->intended('/');

            }
        } 
        **/

    }
}
