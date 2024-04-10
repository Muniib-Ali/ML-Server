@extends('headers.admin-header')
@section('page')
<!DOCTYPE html>
<html>
<link href="{{ asset('css/app.css') }}" rel="stylesheet" type="text/css">

<header>

</header>

<body>
    <div class = "list-users">
    <table class = "table table-striped table-dark">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Slack</th>
                <th>Credits</th>
                <th>Is admin?</th>
                <th>Note</th>
                <th>Change Status</th>
                <th>Activation</th>
            </tr>

        </thead>
        <tbody>
            @foreach ($users as $user )
            @if($user->id != 1)
                <tr>
                    <td>{{$user-> name}}</td>
                    <td>{{$user-> email}}</td>
                    <td>{{$user-> slack}}</td>
                    <td>{{$user-> credits}}</td>
                    @if($user->is_admin == '1')
                    <td>Yes</td>
                    @else
                    <td>No</td>
                    @endif
                    <td>{{$user->notes}}</td>
                    <td>
                        <form action = "admin/change-status/{{$user->id}}" method = "post">
                            @csrf
                            <button type = "submit" id = "change-admin-status">{{$user->is_admin? 'Make User' : 'Make Admin'}}</button>
                        </form>

                    </td>
                    <td>
                        <form action = "admin/change-activation/{{$user->id}}" method = "post">
                            @csrf
                            @if($user->is_active == '1')
                            <button type = "submit" id = "deactivate-account">Deactivate</button>

                            @else
                            <button type = "submit" id = "activate-account">Activate</button>
                            @endif
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