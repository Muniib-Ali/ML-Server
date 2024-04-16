@extends('headers.user-header')
@section('page')
<!DOCTYPE html>
<html>
<link href="{{ asset('css/app.css') }}" rel="stylesheet" type="text/css">

<header>

</header>

<body>

    <div class="request">
        <form class="request-form" action="/creditrequest" method="POST">
            @csrf
            <label for="credits"> How many credits?(1-1000000): </label>
            <input type="number" min="1" max="1000000" placeholder="Credits" name="credits" required>
            <label for="credits"> Reason for credits request: </label>
            <textarea name = "reason" placeholder="Reason" rows= "7" id = "request-reason" required></textarea>
            <button type="submit" id = "credit-request-button"> Send Request </button>

        </form>
    </div>
</body>

</html>
@endsection