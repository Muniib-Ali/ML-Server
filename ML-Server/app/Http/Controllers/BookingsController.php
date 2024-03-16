<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Resource;
use App\Models\ResourceGroup;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\SlackService;

class BookingsController extends Controller
{
    protected $slackService;

    public function __construct(SlackService $slackService)
    {
        $this->slackService = $slackService;
    }
    public function show()
    {

        $resource_groups = ResourceGroup::all();
        $resources = Resource::all();
        $bookings = Booking::all();

        return view('bookings', compact('bookings', 'resources', 'resource_groups'));
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
        $userEmail = $authstatus->email;

        $resource1 = Resource::where('id', $resourceId)->value('name');
        $resourceGroup = ResourceGroup::where('id', $resourceGroupId)->value('resource_group');

        $compareStartDate = Carbon::parse($startDate . ' ' . str_pad($startTime, 2, '0', STR_PAD_LEFT) . ':00:00')->format('Y-m-d H:i:s');


        $compareEndDate = Carbon::parse($endDate . ' ' . str_pad($endTime, 2, '0', STR_PAD_LEFT) . ':00:00')->format('Y-m-d H:i:s');


        

        if ($compareStartDate >= $compareEndDate) {
            return redirect()->back()->withErrors(['error' => 'End time must be greater than start time!']);
        }

    

        $conflictingBookings1 = Booking::where('resource_group_id', $resourceGroupId)
        ->where('resource_id', $resourceId)
        ->where('compare_start_date', '<', $compareEndDate) 
        ->where('compare_end_date', '>', $compareEndDate) 
        ->get();

        $conflictingBookings2 = Booking::where('resource_group_id', $resourceGroupId)
        ->where('resource_id', $resourceId)
        ->where('compare_start_date', '<', $compareStartDate) 
        ->where('compare_end_date', '>', $compareStartDate) 
        ->get();

        $conflictingBookings3 = Booking::where('resource_group_id', $resourceGroupId)
        ->where('resource_id', $resourceId)
        ->where('compare_start_date', '>', $compareStartDate) 
        ->where('compare_end_date', '<', $compareEndDate) 
        ->get();


        $conflictingBookings = $conflictingBookings1
            ->merge($conflictingBookings2)
            ->merge($conflictingBookings3)
            ->unique('id');




        if ($conflictingBookings->count() > 0) {
            return redirect()->back()->withErrors(['error' => 'Your bookings is overlapping with pre existing bookings!']);
        }

        $startTimeRaw = Carbon::parse($request->input('start_date') . ' ' . $request->input('start_time') . ':00');
        $endTimeRaw = Carbon::parse($request->input('end_date') . ' ' . $request->input('end_time') . ':00');

        $hoursDifference = $endTimeRaw->diffInHours($startTimeRaw);

        $resources = Resource::all();
        $specifiedResource = $resources->find($resourceId);
        $cost = $specifiedResource->cost;
        $uThreshold = $specifiedResource->uThreshold;
        $lThreshold = $specifiedResource->lThreshold;


        $overall_cost = $cost * $hoursDifference;
        $users = User::all();
        $user1 = $users->find($authstatus->id);

        if ($user1->credits < $overall_cost) {
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
            'compare_start_date'=> $compareStartDate,
            'compare_end_date'=> $compareEndDate,
            'notes' =>  $notes,
            'resource_name' => $resource1,
            'resource_group_name'=>$resourceGroup,
            'lThreshold'=>$lThreshold,
            'uThreshold'=>$uThreshold,
            'email'=>$userEmail
        ]);

       
        
         return redirect()->back()->with('success', 'Booking was successfully created!');
         
       
    }

    public function showBookings(request $request)
    {
        $authstatus = Auth::user();
        $user = $authstatus->id;
        $bookings = $authstatus->bookings;
        return view('list-bookings', compact('bookings'));
    }

    public function deleteBooking($bookingId)
    {
        $booking  = Booking::where('id', $bookingId);
        $booking->delete();
        return redirect()->back()->with('success', 'Booking was successfully cancelled');
    }

    public function jsonApi(){
        $currentDateTime = Carbon::now();

        $ongoingBookingsQuery1 = \App\Models\Booking::where('start_date', '<', $currentDateTime->toDateString())
            ->where('end_date', '=', $currentDateTime->toDateString())
            ->where('end_time', '>', $currentDateTime->hour)
            ->get();

        $ongoingBookingsQuery2 = \App\Models\Booking::where('start_date', '=', $currentDateTime->toDateString())
            ->where('end_date', '=', $currentDateTime->toDateString())
            ->where('start_time', '<', $currentDateTime->hour)
            ->where('end_time', '>', $currentDateTime->hour)
            ->get();

        $ongoingBookingsQuery3 = \App\Models\Booking::where('start_date', '=', $currentDateTime->toDateString())
            ->where('end_date', '>', $currentDateTime->toDateString())
            ->where('start_time', '<', $currentDateTime->hour)
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

        return response()->json($bookingsArray);

        
    }

    public function getThreshold(){
        $resources = Resource::all();
        return response()->json($resources);
    }

    public function getUsers(){
        $users = User::all();
        return response()->json($users);
    }
}
