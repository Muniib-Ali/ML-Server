<!DOCTYPE html>
<html>
<link href="{{ asset('css/app.css') }}" rel="stylesheet" type="text/css">

<header>

</header>

<body class = "guest-layout">
    <div class = "registration">

        <form method = "POST" action = "/initialize" class = "registration-form">
        <div id = "initialization-header">     
        <h1>Initialize page</h1>
        </div>

            @csrf
            <input type="text" placeholder="Name" name="name" value = "{{old('name')}}">
            @error('name')
            <div class="registration-error-message">
                {{$message}}
            </div>
            @enderror

            <input type="text" placeholder="Email" name="email" value = "{{old('email')}}">

            @error('email')
            <div class="registration-error-message">
                {{$message}}
            </div>
            @enderror

            <input type="text" placeholder="Slack" name="slack" value = "{{old('slack')}}">

            @error('slack')
            <div class="registration-error-message">
                {{$message}}
            </div>
            @enderror

            <input type="text" placeholder="Notes" name="notes" value = "{{old('notes')}}">

            @error('notes')
            <div class="registration-error-message">
                {{$message}}
            </div>
            @enderror

            <input type = "password" placeholder = "Password" name  = "password">

            @error('password')
            <div class="registration-error-message">
                {{$message}}
            </div>
            @enderror

            <input type = "password" placeholder=" Re-enter password" name = "password_confirmation">

            <button type = "submit"> Create Account </button>

        </form>
    </div>
</body>
</html>