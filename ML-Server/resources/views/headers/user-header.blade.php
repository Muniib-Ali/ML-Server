<!DOCTYPE html>

<html>

<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet" type="text/css">

</head>

<body class="user-layout">
    <div class="header-links">
        <div class="header-left">
            <p class="website-name">ML Booking System</p>
        </div>
        <div class="header-right">

            <p class="credits">Credits: {{auth()->user()->credits}} </p>

            <a href="{{url('update-account')}}">Account</a>
            <a href="{{url('bookings')}}">Create booking</a>
            <a href="{{url('list-bookings')}}">Bookings</a>
            <a href="{{url('credits')}}">Request credits</a>
            <a href="{{url('logout')}}"> Sign out </a>



        </div>
    </div>
    <div class="main-body">
        @if($errors->any())
        <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
            {{ $error }}
            @endforeach
        </div>
        @endif


        @if(session('success'))
        <div class="alert alert-success">
        {{ session('success') }}
        </div>
        @endif

        @yield('page')
    </div>
</body>

</html>