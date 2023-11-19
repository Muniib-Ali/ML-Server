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
            <label for="credits"> How many credits?(10-200): </label>
            <input type="number" min="10" max="200" placeholder="credits" name="credits">
            <button type="submit"> Send Request </button>

        </form>
    </div>
</body>

</html>
@endsection