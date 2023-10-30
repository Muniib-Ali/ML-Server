<!DOCTYPE html>

<html> 

<head>
    <meta charset="utf-8">
</head>

<body>
    <div class = "header">
    <a href = "{{url('Users')}}">Users</a>

    @if(auth()->user())
        <a href =  "{{url('logout')}}"> Sign out </a>
    @endif
    </div>

    <div class = "main-body">
    @yield('body')
    </div>
</body>
</html>