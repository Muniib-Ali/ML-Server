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
  <h1>In progress Bookings</h1>

  <table class = "table table-striped table-dark">
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
            @foreach ($filteredUncompleteBookings as $booking )
                <tr>
                    <td>{{$booking-> resource_group_name}}</td>
                    <td>{{$booking-> resource_name}}</td>
                    <td>{{$booking-> start_date}}</td>
                    <td>{{$booking-> start_time}}</td>
                    <td>{{$booking-> end_date}}</td>
                    <td>{{$booking-> end_time}}</td>
                    <td>
                        <form action = "/delete-booking/{{$booking->id}}" method = "post">
                            @csrf
                            <button type = "submit" id = "bookings-delete-button">Cancel</button>
                        </form>

                    </td>
                   
                    
                   
                </tr>
            @endforeach
        </tbody>
    </table>
    <h1>Completed Bookings</h1>
    <table class = "table table-striped table-dark">
        <thead>
            <tr>
                <th>Resource Group</th>
                <th>Resource Name</th>
                <th>Start Date</th>
                <th>Start Time</th>
                <th>End Date</th>
                <th>End Time</th>
                
            </tr>

        </thead>
        <tbody>
            @foreach ($filteredCompleteBookings as $booking )
                <tr>
                    <td>{{$booking-> resource_group_name}}</td>
                    <td>{{$booking-> resource_name}}</td>
                    <td>{{$booking-> start_date}}</td>
                    <td>{{$booking-> start_time}}</td>
                    <td>{{$booking-> end_date}}</td>
                    <td>{{$booking-> end_time}}</td>
            
                   
                    
                   
                </tr>
            @endforeach
        </tbody>
    </table>



    
  </div>
  


  

</body>

</html>
@endsection