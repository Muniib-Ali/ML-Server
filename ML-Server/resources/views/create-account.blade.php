<!DOCTYPE html>
<html>
<link href="{{ asset('css/app.css') }}" rel="stylesheet" type="text/css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/parsley.js/2.9.2/parsley.min.js" integrity="sha512-eyHL1atYNycXNXZMDndxrDhNAegH2BDWt1TmkXJPoGf1WLlNYt08CSjkqF5lnCRmdm3IrkHid8s2jOUY4NIZVQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<header>

</header>

<body class="guest-layout">
    <div class="registration">
        <form method="POST" action="/createaccount" class="registration-form">
            @csrf
            <label for="name">Name </label>
            <input type="text" placeholder="name" name="name" value = "{{old('name')}}">

            @error('name')
            <div class="registration-error-message">
                {{$message}}
            </div>
            @enderror


            <label for="email"> Email </label>
            <input type="text" placeholder="email" name="email" value = "{{old('email')}}">

            @error('email')
            <div class="registration-error-message">
                {{$message}}
            </div>
            @enderror


            <label for="slack"> Slack </label>
            <input type="text" placeholder="slack" name="slack" value = "{{old('slack')}}">

            @error('slack')
            <div class="registration-error-message">
                {{$message}}
            </div>
            @enderror

            <label for="notes"> Notes: </label>
            <input type="text" placeholder="notes" name="notes" value = "{{old('notes')}}">
            @error('notes')
            <div class="registration-error-message">
                {{$message}}
            </div>
            @enderror


            <label for="password"> Password </label>
            <input type="password" placeholder="password" name="password">
            @error('password')
            <div class="registration-error-message">
                {{$message}}
            </div>
            @enderror

            <label for="password_confirmation"> Confirm Password </label>
            <input type="password" placeholder=" re-enter password" name="password_confirmation">

            <button type="submit"> Create Account </button>
            <a href="/login" class="account-links">Already have an account? Login here!</a>

        </form>
    </div>
</body>

</html>