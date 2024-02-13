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

        $resource1 = Resource::where('id', $resourceId)->value('name');

        if ($startDate == $endDate && $startTime >= $endTime) {
            return redirect()->back()->withErrors(['error' => 'End time must be greater than start time!']);
        }

        $conflictingBookings = Booking::where('resource_group_id', $resourceGroupId)
            ->where(function ($query) use ($resourceId, $startTime, $endTime, $startDate, $endDate) {
                $query->where('resource_id', $resourceId)
                    ->where('end_time', '>', $startTime)
                    ->where('start_time', '<', $endTime)
                    ->where('start_date', '<=', $endDate)
                    ->where('end_date', '>=', $startDate);
            })
            ->orWhere(function ($query) use ($resourceId, $startTime, $endTime, $startDate, $endDate) {
                $query->where('resource_id', $resourceId)
                    ->where('end_time', '>', $startTime)
                    ->where('start_time', '>', $endTime)
                    ->where('start_date', '<', $endDate)
                    ->where('end_date', '>=', $endDate);
            })
            ->orWhere(function ($query) use ($resourceId, $startTime, $endTime, $startDate, $endDate) {
                $query->where('resource_id', $resourceId)
                    ->where('start_date', '=', $startDate)
                    ->where('start_time', '<', $startTime)
                    ->where('end_date', '>', $endDate);
            })
            ->orWhere(function ($query) use ($resourceId, $startTime, $endTime, $startDate, $endDate) {
                $query->where('resource_id', $resourceId)
                    ->where('start_time', '>', $startTime)
                    ->where('start_date', '=', $startDate)
                    ->where('end_date', '>', $endDate)
                    ->where('start_time', '<', $endTime);
            })
            ->orWhere(function ($query) use ($resourceId, $startTime, $endTime, $startDate, $endDate) {
                $query->where('resource_id', $resourceId)
                    ->where('end_date', '=', $endDate)
                    ->where('start_date', '>', $startDate)
                    ->where('start_time', '<', $endTime);
            })
            ->orWhere(function ($query) use ($resourceId, $startTime, $endTime, $startDate, $endDate) {
                $query->where('resource_id', $resourceId)
                    ->where('end_date', '=', $startDate)
                    ->where('end_time', '>', $startTime)
                    ->where('start_date', '<', $startDate);
            })
            ->orWhere(function ($query) use ($resourceId, $startTime, $endTime, $startDate, $endDate) {
                $query->where('resource_id', $resourceId)
                    ->where('start_date', '=', $startDate)
                    ->where('start_time', '>', $startTime)
                    ->where('end_date', '<', $endDate);
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
            'notes' =>  $notes,
            'resource_name' => $resource1
        ]);

        /** 
         * $message = "New booking created!";
        * 
         *  $this->slackService->sendMessage($message, '#testing-bot');

        * 
         *  $userId = $user1->slack;
         * 
         * $message = "Booking for " . $user1->name . " from " . $startTime . " on " . $startDate . " to " . $endTime . " on " . $endDate . " has been confirmed!";   
         * 
         * $this->slackService->sendMessage($message, $userId);
         * 
         * return redirect()->intended('/home');
         * 
         * 
         * 
         * 
        */
       
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
}
