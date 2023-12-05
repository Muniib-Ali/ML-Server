@extends('headers.admin-header')
@section('page')
<!DOCTYPE html>
<html>
<header>

</header>

<body>
    <div class = "list-users">
    <table class = "users-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Email</th>
                <th>Slack</th>
                <th>Credits</th>
                <th>Admin Status</th>
                <th>Change Status</th>
            </tr>

        </thead>
        <tbody>
            @foreach ($users as $user )
            @if($user->id != 1)
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
                    <td>
                        <form action = "admin/change-status/{{$user->id}}" method = "post">
                            @csrf
                            <button type = "submit">{{$user->is_admin? 'Make User' : 'Make Admin'}}</button>
                        </form>

                    </td>
                </tr>
            @endif
            @endforeach
        </tbody>
    <table>
    </table>
</body>
</html>
@endsection