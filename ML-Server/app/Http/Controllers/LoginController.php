<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function login(Request $request){
        $this->validate($request,[
            'slack' => 'required',
            'password' => 'required'
        ]);

        echo "successfully signed in";

    }
}
