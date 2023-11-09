<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function requestCredits(){

    }

    public function show(){
        return view('request-credits');
    }
}
