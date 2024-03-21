@extends('headers.user-header')
@section('page')
<!DOCTYPE html>
<html>
<link href="{{ asset('css/app.css') }}" rel="stylesheet" type="text/css">
<header>

</header>

<body class="guest-layout">
    <div class="registration">
        <form method="POST" action="/update-account" class="registration-form">
            @csrf
            <input type="text" placeholder="Name" name="name">

            @error('name')
            <div class="registration-error-message">
                {{$message}}
            </div>
            @enderror


            <input type="text" placeholder="Email" name="email">

            @error('email')
            <div class="registration-error-message">
                {{$message}}
            </div>
            @enderror


            <input type="text" placeholder="Slack" name="slack">

            @error('slack')
            <div class="registration-error-message">
                {{$message}}
            </div>
            @enderror

            <input type="text" placeholder="Notes" name="notes">
            @error('notes')
            <div class="registration-error-message">
                {{$message}}
            </div>
            @enderror


            <input type="password" placeholder="Password" name="password">
            @error('password')
            <div class="registration-error-message">
                {{$message}}
            </div>
            @enderror

            <input type="password" placeholder=" Re-enter password" name="password_confirmation">

            <button type="submit"> Update details</button>

        </form>
    </div>
</body>

</html>
@endsection