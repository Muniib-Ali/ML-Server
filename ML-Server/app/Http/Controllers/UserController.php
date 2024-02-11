<?php

namespace App\Http\Controllers;

use App\Models\CreditRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class UserController extends Controller
{
    public function requestCredits(Request $request)
    {
        $user = Auth::user();
        CreditRequest::create([
            'user_id' => $user->id,
            'value' => $request->credits
        ]);

        return redirect()->intended('/home');
    }

    public function show()
    {
        return view('request-credits');
    }

    public function showUpdate()
    {
        return view('update-account');
    }

    public function updateAccount(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'nullable|string|max:255',
            'email' => 'nullable|string|email|max:255|unique:users,email,'.$request->user()->id.',id',
            'slack' => 'nullable|string|max:255|unique:users,slack,'.$request->user()->id.',id',
            'notes' => 'nullable|string|max:255',
            'password' => 'nullable|string|min:8|confirmed',
        ], [
            'slack.unique' => 'The slack id has already been taken.'

        ]);
    
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $userInformation = [];
        if ($request->filled('name')) {
            $userInformation['name'] = $request->name;
        }
        if ($request->filled('email')) {
            $userInformation['email'] = $request->email;
        }
        if ($request->filled('slack')) {
            $userInformation['slack'] = $request->slack;
        }
        if ($request->filled('notes')) {
            $userInformation['notes'] = $request->notes;
        }
        if ($request->filled('password')) {
            $userInformation['password'] = bcrypt($request->password);
        }
    
        User::where('id', $request->user()->id)->update($userInformation);

        return redirect()->intended('/update-account')->with('success', 'Account information was successfully updated!');
    }
}
