@extends('headers.user-header')
@section('body')
<!DOCTYPE html>
<html>
<header>

</header>

<body>
    <form class = "request-form" action = "/creditrequest" method = "POST" >
        @csrf
        <label for = "credits"> How many credits?(10-200): </label>
        <input type = "number" min = "10" max = "200" placeholder = "credits" name = "credits"> 
        <button type = "submit"> Send Request </button>

    </form>
</body>
</html>
@endsection