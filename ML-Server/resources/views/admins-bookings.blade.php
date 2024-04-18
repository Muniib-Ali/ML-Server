@extends('headers.admin-header')
@section('page')
<!DOCTYPE html>
<html>
<link href="{{ asset('css/app.css') }}" rel="stylesheet" type="text/css">
<header>

</header>

<body>


    <div class="list-users">



        <table class="table table-striped table-dark">
            <thead>
                <tr>
                    <th>Email</th>
                    <th>Resource Name</th>
                    <th>Start date</th>
                    <th>Start time</th>
                    <th>End date</th>
                    <th>End time</th>
                    <th>Notes</th>
                </tr>

            </thead>
            <tbody>
                @foreach ($bookings as $booking )
                <tr>

                    <td>{{ $booking['email'] }}</td>
                    <td>{{ $booking['resource_name'] }}</td>
                    <td>{{ $booking['start_date'] }}</td>
                    <td>{{ $booking['start_time'] }}</td>
                    <td>{{ $booking['end_date'] }}</td>
                    <td>{{ $booking['end_time'] }}</td>
                    <td>{{ $booking['notes'] }}</td>




                </tr>
                @endforeach
            </tbody>
        </table>
    </div>


</body>

</html>
@endsection