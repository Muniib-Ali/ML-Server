@extends('headers.user-header')
@section('page')
<!DOCTYPE html>
<html>
<link href="{{ asset('css/app.css') }}" rel="stylesheet" type="text/css">
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.9/index.global.min.js'></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.9/main.min.css" />



<header>

</header>

<body>
  <div class="listed-bookings">
  <table class = "listed-bookings-table">
        <thead>
            <tr>
                <th>Resource Group</th>
                <th>Resource Name</th>
                <th>Start Date</th>
                <th>Start Time</th>
                <th>End Date</th>
                <th>End Time</th>
                <th>Cancel</th>
                
            </tr>

        </thead>
        <tbody>
            @foreach ($bookings as $booking )
                <tr>
                    <td>{{$booking-> resource_group_id}}</td>
                    <td>{{$booking-> resource_name}}</td>
                    <td>{{$booking-> start_date}}</td>
                    <td>{{$booking-> start_time}}</td>
                    <td>{{$booking-> end_date}}</td>
                    <td>{{$booking-> end_time}}</td>
                    <td>
                        <form action = "/delete-booking/{{$booking->id}}" method = "post">
                            @csrf
                            <button type = "submit">Delete</button>
                        </form>

                    </td>
                   
                    
                   
                </tr>
            @endforeach
        </tbody>
    </table>
    
  </div>
  


  

</body>

</html>
@endsection