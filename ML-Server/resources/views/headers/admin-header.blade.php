<!DOCTYPE html>

<html> 

<head>
    <meta charset="utf-8">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet" type="text/css" >
</head>

<body class = "admin-layout">
    <div class = "header-links">
    <p class = "website-name">ML Management System</p>
    <a href = "{{url('users')}}">Users</a>
    <a href = "{{url('requests')}}">Requests</a>

    @auth
    <a href =  "{{url('logout')}}"> Sign out </a>
    @endauth

    @guest
    <a href =  "{{url('login')}}"> Login </a>
    <a href =  "{{url('createaccount')}}"> Sign up </a>

    @endguest
    </div>
    <div class = "main-body">
    @yield('page')
    </div>
</body>
</html>