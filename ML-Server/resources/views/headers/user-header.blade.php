<!DOCTYPE html>

<html> 

<head>
    <meta charset="utf-8">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet" type="text/css" >

</head>

<body class = "user-layout">
    <div class = "header-links">
    <p class = "website-name">ML Booking System</p>
    <a href = "{{url('credits')}}">Request credits</a>
    @auth
    <p class = "credits"> {{auth()->user()->credits}} </p>
    <a href =  "{{url('logout')}}"> Sign out </a>
    @endauth

    @guest
    <a href =  "{{url('login')}}"> Login </a>
    <a href =  "{{url('createaccount')}}"> Sign up </a>
    <p>
    @endguest
    </div>
    <div class = "main-body">
    @yield('page')
    </div>
</body>
</html>