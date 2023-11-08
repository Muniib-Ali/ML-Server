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
                <th>Email</th>
                <th>Slack</th>
                <th>Credits</th>
                <th>Admin Status</th>
            </tr>

        </thead>
        <tbody>
            @foreach ($users as $user )
                <tr>
                    <td>{{$user-> id}}</td>
                    <td>{{$user-> email}}</td>
                    <td>{{$user-> slack}}</td>
                    <td>{{$user-> credits}}</td>
                    @if($user->is_admin == '1')
                    <td>true</td>
                    @else
                    <td>false</td>
                    @endif
                </tr>
            @endforeach
        </tbody>
    <table>
</body>
</html>
@endsection