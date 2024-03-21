<!DOCTYPE html>
<html>

<link href="{{ asset('css/app.css') }}" rel="stylesheet" type="text/css">

<header>

</header>

<body class = "guest-layout">
    @if($errors->any())
    <div class="alert alert-danger">
    @foreach ($errors->all() as $error)
        {{ $error }}
    @endforeach
    </div>
    @endif
    <div class="login">
        <form method="POST" action="/login" class="login-form">
            @csrf

            <!--<label for="email"> Email </label>-->
            <input type="text" placeholder="Email" name="email">

            <!--<label for="password"> Password </label>-->
            <input type="password" placeholder="Password" name="password">

            <button type="submit"> Login </button>
            <div class = "login-page-links">
            <a href = "/signup" class = "account-links">Don't have an account?<br>Create one here!</a>
            <a href = "/password-reset" class = "account-links">Forgot password?<br>Reset here!</a>
            </div>


        </form>
    </div>
</body>

</html>