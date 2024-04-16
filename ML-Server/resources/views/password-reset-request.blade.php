<!DOCTYPE html>
<html>
<link href="{{ asset('css/app.css') }}" rel="stylesheet" type="text/css">

<head>
</head>

<body class="guest-layout">
@if(session('success'))
        <div class="alert alert-success">
        {{ session('success') }}
        </div>
        @endif
    @if($errors->any())
    <div class="alert alert-danger">
        @foreach ($errors->all() as $error)
        {{ $error }}
        @endforeach
    </div>
    @endif
    <div class="login">
        <form method="POST" action="/password-reset" class="login-form">
            @csrf

            <input type="email" placeholder="Enter your email" name="email" required>

            <button type="submit"> Reset Password </button>
        </form>
    </div>
</body>

</html>