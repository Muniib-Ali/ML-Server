<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\CreditRequest;
use App\Models\Resource;
use App\Models\ResourceGroup;
use App\Models\User;
use App\Rules\UniqueNameInResourceGroup;
use Carbon\Carbon;
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

    public function changeActivationStatus($id){
        $users = User::all();
        $user = $users->find($id);

        $user->is_active = !$user->is_active;
        $user ->save();


        return redirect()->intended('/users');
    }


    public function listRequests(){
        $requests = CreditRequest::all();
        return view ('list-credit-requests', ['requests' => $requests]);
    }

    public function showAdminBookings(){
        $currentDateTime = Carbon::now();

        $ongoingBookingsQuery1 = \App\Models\Booking::where('start_date', '<', $currentDateTime->toDateString())
            ->where('end_date', '=', $currentDateTime->toDateString())
            ->where('end_time', '>', $currentDateTime->hour)
            ->get();

        $ongoingBookingsQuery2 = \App\Models\Booking::where('start_date', '=', $currentDateTime->toDateString())
            ->where('end_date', '=', $currentDateTime->toDateString())
            ->where('start_time', '<=', $currentDateTime->hour)
            ->where('end_time', '>', $currentDateTime->hour)
            ->get();

        $ongoingBookingsQuery3 = \App\Models\Booking::where('start_date', '=', $currentDateTime->toDateString())
            ->where('end_date', '>', $currentDateTime->toDateString())
            ->where('start_time', '<=', $currentDateTime->hour)
            ->get();

        $ongoingBookingsQuery4 = \App\Models\Booking::where('start_date', '<', $currentDateTime->toDateString())
            ->where('end_date', '>', $currentDateTime->toDateString())
            ->get();

        // Combine the results of all queries
        $ongoingBookings = $ongoingBookingsQuery1
            ->merge($ongoingBookingsQuery2)
            ->merge($ongoingBookingsQuery3)
            ->merge($ongoingBookingsQuery4)
            ->unique('id');



        $bookingsArray = $ongoingBookings->toArray();
        return view('admins-bookings', ['bookings' => $bookingsArray]);
    }

    public function acceptRequest($id){

        $requests = CreditRequest::all();
        $request = $requests->find($id);

        $users = User::all();
        $user = $users->find($request->user_id);


        $user->credits = $user->credits + $request->value;
        $user->save();

        $request->setAttribute('status', 'Accepted');
        $request->save();

        return redirect()->intended('/requests');


    }

    public function declineRequest($id){
        $requests = CreditRequest::all();
        $request = $requests->find($id);
        $request->setAttribute('status', 'Rejected');
        $request->save();
        return redirect()->intended('/requests');




    }

    public function showResourceRequest(){
        $resource_group = ResourceGroup::all();
        $resources = Resource::all();
        return view('create-resources', compact('resource_group','resources' ));
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

        if($request->resource_group == ""){
            return redirect()->back()->withErrors(['error' => 'Select a valid value']);
        }
        $this->validate($request, [
            'name' => ['required','string', 'max:255', new UniqueNameInResourceGroup($request->resource_group)]
        ]);
        
        $resource_groups = ResourceGroup::all();
        $resource_group = $resource_groups->find($request->resource_group);

        $uThreshold = $request->filled('uThreshold') ? $request->uThreshold : null;
        $lThreshold = $request->filled('lThreshold') ? $request->lThreshold : null;

        $number = $request->filled('number') ? $request->number : null;


        Resource::create([
            'resource_group_id' => $request->resource_group,
            'resource_group_name' => $resource_group->resource_group,
            'name' => $request->name,
            'cost' => $request->value,
            'number'=>$number,
            'uThreshold' => $uThreshold,
            'lThreshold'=>$lThreshold
        ]);

        return redirect()-> intended('/resources');

    }

    public function changeResourceStatus($id){
        $resources = Resource::all();
        $resource = $resources->find($id);

        $resource->is_enabled = !$resource->is_enabled;
        $resource ->save();


        return redirect()->intended('/resources');
    }

    public function deleteResource($id){
        Booking::where('resource_id', $id)->delete();
        Resource::where('id', $id)->delete();
        return redirect()->intended('/resources');
    }

    public function clearCredits(){
        $users = User::all();
        foreach ($users as $user) {
        $user->credits = 0;
        $user->save();
        }

        return redirect()->back();
    }

    public function setCredits(Request $request){
        $amount = $request->credits;
        $users = User::all();
        foreach ($users as $user) {
            $user->credits = $amount;
            $user->save();
        }
        return redirect()->back();

    }
}
