<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function listUsers(){
        $users = User::all();
        return view('listusers', ['users' => $users]);

    }

    public function changeStatus($id){
        $users = User::all();
        $user = $users->find($id);

        $user->is_admin = !$user->is_admin;
        $user ->save();


        return redirect()->intended('/users');
    }
}
