<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LogoutController extends Controller
{
    public function logout(){
        auth()->logout();
        
        echo "successfully signed out";
    }
}
