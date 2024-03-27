<!DOCTYPE html>

<html>

<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body class="user-layout">
    <div class="header-links">
        <div class="header-left">
            <p class="website-name">ML Booking System</p>
        </div>
        <div class="header-right">

            <p class="credits">Credits: {{auth()->user()->credits}} </p>
            <i class="fa-solid fa-coins"></i>
            <a href="{{url('update-account')}}">Account</a>
            <a href="{{url('')}}">Create booking</a>
            <a href="{{url('list-bookings')}}">Bookings</a>
            <a href="{{url('credits')}}">Request credits</a>
            @if(auth()->user()->is_admin)
            <a href="{{url('users')}}">Users</a>
            <a href="{{url('requests')}}">Requests</a>
            <a href="{{url('resources')}}">Resources</a>

            @endif
            <a href="{{url('logout')}}"> Sign out </a>
            <i class="fa-solid fa-arrow-right-from-bracket"></i>

            

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