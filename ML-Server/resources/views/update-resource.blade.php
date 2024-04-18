@extends('headers.user-header')
@section('page')
<!DOCTYPE html>
<html>
<link href="{{ asset('css/app.css') }}" rel="stylesheet" type="text/css">
<header>

</header>

<body class="guest-layout">
    <div class="registration">
        <form method="POST" action="{{ route('admin.update-resource', $resource->id) }}" class="registration-form">
            @csrf
            <input type="text" placeholder="Resource Name" name="name" value="{{$resource->name}}" required>
            

            <input type="number" min="0" max="1000000" placeholder="Cost" name="cost" value="{{$resource->cost}}" required>
            

            <input type="number" min="0" max="1000000" placeholder="Upper Threshold" name="threshold" value="{{$resource->uThreshold}}" required>
            

            <button type="submit"> Update Resource</button>

        </form>
    </div>
</body>

</html>
@endsection