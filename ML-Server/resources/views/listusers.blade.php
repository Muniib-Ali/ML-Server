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
                <th>Change Status</th>
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
                    <td>
                        <form action = "admin/change-status/{{$user->id}}" method = "post">
                            @csrf
                            <button type = "submit">{{$user->is_admin? 'Make User' : 'Make Admin'}}</button>
                        </form>

                    </td>
                </tr>
            @endforeach
        </tbody>
    <table>
</body>
</html>
@endsection