<!DOCTYPE html>

<html>

<head>
    <meta charset="utf-8">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet" type="text/css">
</head>

<body class="admin-layout">
    <div class="header-links">
        <div class="header-left">
            <p class="website-name">ML Management System</p>
        </div>

        <div class="header-right">
            <a href="{{url('users')}}">Users</a>
            <a href="{{url('requests')}}">Requests</a>
            <a href="{{url('resources')}}">Resources</a>



            @auth
            <a href="{{url('logout')}}"> Sign out </a>
            @endauth

            @guest
            <a href="{{url('login')}}"> Login </a>
            <a href="{{url('createaccount')}}"> Sign up </a>

            @endguest
        </div>
    </div>
    @if($errors->any())
    <div class="alert alert-danger">
    @foreach ($errors->all() as $error)
        {{ $error }}
    @endforeach
    </div>
    @endif
    <div class="main-body">
        @yield('page')
    </div>
</body>

</html>