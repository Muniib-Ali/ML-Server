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
        Log::info('Current date and time: ' . $currentDateTime);
        
        $ongoingBookings = Booking::where(function ($query) use ($currentDateTime) {
            $query->whereDate('start_date', '<=', $currentDateTime->toDateString())
                ->where(function ($query) use ($currentDateTime) {
                    $query->whereRaw('start_date < ?', [$currentDateTime->toDateString()])
                        ->orWhere('start_time', '<=', $currentDateTime->format('H:i:s'));
                });
        })
            ->where(function ($query) use ($currentDateTime) {
                $query->whereDate('end_date', '>=', $currentDateTime->toDateString())
                    ->where(function ($query) use ($currentDateTime) {
                        $query->whereRaw('end_date > ?', [$currentDateTime->toDateString()])
                            ->orWhere('end_time', '>=', $currentDateTime->format('H:i:s'));
                    });
            })
            ->get();

        Log::info('Ongoing bookings: ', $ongoingBookings->toArray());

       
        $bookingsArray = $ongoingBookings->toArray();


       
        $filePath = base_path('resources/bookings.json');
        file_put_contents($filePath, '');
        file_put_contents($filePath, json_encode($bookingsArray));
    }

    
}