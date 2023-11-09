<?php

namespace App\Http\Controllers;

use App\Models\CreditRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function requestCredits(Request $request){
        $user = Auth::user();
        CreditRequest::create([
            'user_id' => $user->id,
            'value' => $request -> credits
        ]);

        return redirect()->intended('/home');

    }

    public function show(){
        return view('request-credits');
    }
}
