<?php

namespace App\Services;

use App\Models\Booking;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class BookingJsonService
{
    public function checkBookings()
    {
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

        Log::info('Ongoing bookings: ', $ongoingBookings->toArray());


        $bookingsArray = $ongoingBookings->toArray();



        $filePath = base_path('resources/bookings.json');
        file_put_contents($filePath, '');
        file_put_contents($filePath, json_encode($bookingsArray));
    }
}
