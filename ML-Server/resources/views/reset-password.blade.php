<!DOCTYPE html>
<html lang="en">
<link href="{{ asset('css/app.css') }}" rel="stylesheet" type="text/css">

<head>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet" type="text/css">
</head>
<body class="guest-layout">
    @if($errors->any())
    <div class="alert alert-danger">
    @foreach ($errors->all() as $error)
        {{ $error }}
    @endforeach
    </div>
    @endif
    <div class="login">
        <form method="POST" action="{{ route('password.update') }}" class="login-form">
            @csrf

            <input type="hidden" name="token" value="{{ $token }}">

            <label for="email"> Email </label>
            <input type="email" placeholder="Enter your email" name="email" value="{{ old('email') }}" required autofocus>

            <label for="password"> New Password </label>
            <input type="password" placeholder="Enter your new password" name="password" required>

            <label for="password-confirm"> Confirm Password </label>
            <input type="password" placeholder="Confirm your new password" name="password_confirmation" required>

            <button type="submit"> Reset Password </button>
        </form>
    </div>
</body>
</html>