<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class InitializeController extends Controller
{
    //
    public function initialize(Request $request){

    }

    public function show(){
        return view('initialize');
    }


    public function registrate(Request $request){

        $this->validate($request, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'max:255', 'email', 'unique:users'],
            'slack' => ['required', 'string', 'max:255', 'unique:users'],
            'notes' => ['max:255'],
            'password' => ['required', 'string', 'confirmed']
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'slack' => $request->slack,
            'notes' => $request->notes,
            'password' => Hash::make($request->password),
            'is_admin' => true,
            'is_active' => true
        ]);
        $credentials = $request->only('slack', 'password');
 
        if (Auth::attempt($credentials)) {
            // Authentication passed...
            return redirect()->intended('/requests');
        }

    }
}