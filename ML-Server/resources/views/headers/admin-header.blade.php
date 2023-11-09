<!DOCTYPE html>

<html> 

<head>
    <meta charset="utf-8">
</head>

<body>
    <div class = "header">
    <a href = "{{url('users')}}">Users</a>
    <a href = "{{url('requests')}}">Requests</a>

    @auth
    <a href =  "{{url('logout')}}"> Sign out </a>
    @endauth

    @guest
    <a href =  "{{url('login')}}"> Login </a>
    <a href =  "{{url('createaccount')}}"> Sign up </a>

    @endguest
    <div class = "main-body">
    @yield('body')
    </div>
</body>
</html>