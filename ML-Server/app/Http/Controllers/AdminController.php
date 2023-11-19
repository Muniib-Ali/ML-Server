<?php

namespace App\Http\Controllers;

use App\Models\CreditRequest;
use App\Models\Resource;
use App\Models\ResourceGroup;
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
        $resource_group = ResourceGroup::all();
        return view('create-resources', ['resource_group' => $resource_group]);
    }

    public function createResourceGroup(Request $request){
        $this->validate($request, [
            'resource_group' => ['required', 'string', 'max:255', 'unique:resource_group']
        ]);

        ResourceGroup::create([
            'resource_group' => $request->resource_group
        ]);

        return redirect()-> intended('/resources');

    }


    public function createResource(Request $request){
        $this->validate($request, [
            'name' => ['required','string', 'max:255', 'unique:resource']
        ]);
        
        Resource::create([
            'resource_group_id' => $request->resource_group,
            'name' => $request->name,
            'cost' => $request->value
        ]);

        return redirect()-> intended('/resources');

    }
}
