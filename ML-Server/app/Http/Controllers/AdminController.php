<?php

namespace App\Http\Controllers;

use App\Models\CreditRequest;
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


    public function listRequests(){
        $requests = CreditRequest::all();
        return view ('list-credit-requests', ['requests' => $requests]);
    }

    public function acceptRequest($id){

        $requests = CreditRequest::all();
        $request = $requests->find($id);

        $users = User::all();
        $user = $users->find($request->user_id);


        $user->credits = $user->credits + $request->value;
        $user->save();

        $request->setAttribute('status', 'approved');
        $request->save();

        return redirect()->intended('/requests');


    }

    public function declineRequest($id){
        $requests = CreditRequest::all();
        $request = $requests->find($id);
        $request->setAttribute('status', 'rejected');
        $request->save();
        return redirect()->intended('/requests');




    }

    public function showResourceRequest(){
        return view('create-resources');
    }
}
