<!DOCTYPE html>

<html>

<head>
    <meta charset="utf-8">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet" type="text/css">

</head>

<body class="user-layout">
    <div class="header-links">
        <div class="header-left">
            <p class="website-name">ML Booking System</p>
        </div>
        <div class="header-right">

            <p class="credits">Credits: {{auth()->user()->credits}} </p>
            <a href="{{url('credits')}}">Request credits</a>
            <a href="{{url('logout')}}"> Sign out </a>


            
        </div>
    </div>
    <div class="main-body">
        @yield('page')
    </div>
</body>

</html>