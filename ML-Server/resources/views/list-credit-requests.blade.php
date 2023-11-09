@extends('headers.admin-header')
@section('body')
<!DOCTYPE html>
<html>
<header>

</header>

<body>
    <table>
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
            @endforeach
        </tbody>
    <table>
</body>
</html>
@endsection