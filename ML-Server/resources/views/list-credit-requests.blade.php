@extends('headers.admin-header')
@section('page')
<!DOCTYPE html>
<html>
<header>

</header>

<body>
    <table class = "requests-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>User ID</th>
                <th>Amount requested</th>
                <th>Accept</th>
                <th>Decline</th>
            </tr>

        </thead>
        <tbody>
            @foreach ($requests as $request )
            @if($request -> status == "pending")
                <tr>
                    <td>{{$request-> id}}</td>
                    <td>{{$request -> user_id}}</td>
                    <td>{{$request -> value}}</td>
                    <td>
                        <form action = "requests/change-status/{{$request->id}}/accept" method = "post">
                            @csrf
                            <button type = "submit">Accept</button>
                        </form>
                        
                    </td>
                    <td>
                        <form action = "requests/change-status/{{$request->id}}/decline" method = "post">
                            @csrf
                            <button type = "submit">Decline</button>
                        </form>
                        
                    </td>
                </tr>
            @endif
            @endforeach
        </tbody>
    <table>

    <table class = "completed-requests-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>User ID</th>
                <th>Amount requested</th>
                <th>Status</th>
            </tr>

        </thead>
        <tbody>
            @foreach ($requests as $request )
            @if($request -> status != "pending")
                <tr>
                    <td>{{$request-> id}}</td>
                    <td>{{$request -> user_id}}</td>
                    <td>{{$request -> value}}</td>
                    <td>{{$request -> status}}</td>

                </tr>
            @endif
            @endforeach
        </tbody>
    <table>
</body>
</html>
@endsection