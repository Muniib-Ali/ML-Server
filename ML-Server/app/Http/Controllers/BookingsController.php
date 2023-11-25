<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Resource;
use App\Models\ResourceGroup;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingsController extends Controller
{
    public function show()
    {

        $resource_groups = ResourceGroup::all();
        $resources = Resource::all();
        return view('bookings', ['resource_groups' => $resource_groups], ['resources' => $resources]);
    }

    public function getResourcesByGroup(Request $request)
    {
        $groupId = $request->input('group_id');
        $resources = Resource::where('resource_group_id', $groupId)->get();

        return response()->json($resources);
    }

    public function book(Request $request)
    {
        $resourceGroupId = $request->input('resource_group');
        $resourceId = $request->input('resource');
        $startTime = $request->input('start_time');
        $endTime = $request->input('end_time');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $notes = $request->input('notes');
        $authstatus = Auth::user();
        $user = $authstatus->id;

        $conflictingBookings = Booking::where('resource_group_id', $resourceGroupId)
            ->where('resource_id', $resourceId)
            ->where(function ($query) use ($startTime, $endTime, $startDate, $endDate) {
                $query->where('end_time', '>', $startTime)
                    ->where('start_time', '<', $endTime)
                    ->where('start_date', '<=', $endDate)
                    ->where('end_date', '>=', $startDate);
            })
            ->get();

        if ($conflictingBookings->count() > 0) {
            return redirect()->back()->withErrors(['error' => 'Your bookings is overlapping with pre existing bookings!']);
        }

        
        $startTimeRaw = Carbon::parse($request->input('start_date') . ' ' . $request->input('start_time') . ':00');
        $endTimeRaw = Carbon::parse($request->input('end_date') . ' ' . $request->input('end_time') . ':00');

        
        $hoursDifference = $endTimeRaw->diffInHours($startTimeRaw);

        $resources = Resource::all();
        $specifiedResource = $resources->find($resourceId);
        $cost = $specifiedResource->cost;

        $overall_cost = $cost * $hoursDifference;
        $users = User::all();
        $user1 = $users->find($authstatus->id);

        if($user1->credits < $overall_cost){
            return redirect()->back()->withErrors(['error' => 'You do not have enough credits to book this session!']);

        }
        $user1->credits = $user1->credits - $overall_cost;
        $user1->save();



        Booking::create([
            'resource_group_id' => $resourceGroupId,
            'resource_id' => $resourceId,
            'user_id' => $user,
            'start_date' => $startDate,
            'start_time' => $startTime,
            'end_date' => $endDate,
            'end_time' => $endTime,
            'notes' =>  $notes
        ]);


        return redirect()->intended('/home');
    }
}
