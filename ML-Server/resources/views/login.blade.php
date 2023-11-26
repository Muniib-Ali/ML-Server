<!DOCTYPE html>
<html>
<link href="{{ asset('css/app.css') }}" rel="stylesheet" type="text/css">

<header>

</header>

<body class = "guest-layout">
    <div class="login">
        <form method="POST" action="/login" class="login-form">
            @csrf

            <label for="email"> email </label>
            <input type="text" placeholder="email" name="email">

            <label for="password"> Password </label>
            <input type="password" placeholder="password" name="password">

            <button type="submit"> Login </button>
            <a href = "/signup" class = "account-links">Don't have an account? Create one here!</a>

        </form>
    </div>
</body>

</html>