<!DOCTYPE html>

<html> 

<head>
    <meta charset="utf-8">
</head>

<body>
    <div class = "header">
    <p class = "website-name">ML Server Booking</p>
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
    <div class = "main-body">
    @yield('body')
    </div>
</body>
</html>