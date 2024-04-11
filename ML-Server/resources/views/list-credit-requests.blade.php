@extends('headers.admin-header')
@section('page')
<!DOCTYPE html>
<html>
<link href="{{ asset('css/app.css') }}" rel="stylesheet" type="text/css">

<header>

</header>

<body>
    <div class = "requests-buttons-container">
    <form class="clear-credits-form" action="/clearcredits" method="POST">
        @csrf

        <button type="submit" id="clear-credits-button"> Clear credits </button>

    </form>


    <form class="setcredits-form" action="/setcredits" method="POST">
        @csrf
        <input type="number" min="1" max="1000000" placeholder="Credits" name="credits">


        <button type="submit" id="assign-credits-button"> Assign Credits </button>

    </form>



</div>


    <div class="requests-container">



        <table class="table table-striped table-dark">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
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
                    <td>{{$request -> name}}</td>
                    <td>{{$request -> email}}</td>
                    <td>{{$request -> value}}</td>
                    <td>
                        <form action="requests/change-status/{{$request->id}}/accept" method="post">
                            @csrf
                            <button type="submit" id="credit-request-accept">Accept</button>
                        </form>

                    </td>
                    <td>
                        <form action="requests/change-status/{{$request->id}}/decline" method="post">
                            @csrf
                            <button type="submit" id="credit-request-decline">Decline</button>
                        </form>

                    </td>
                </tr>
                @endif
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="completed-requests-container">
        <table class="table table-striped table-dark">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Amount requested</th>
                    <th>Status</th>
                </tr>

            </thead>
            <tbody>
                @foreach ($requests as $request )
                @if($request -> status != "pending")
                <tr>
                    <td>{{$request-> id}}</td>
                    <td>{{$request -> name}}</td>
                    <td>{{$request -> email}}</td>
                    <td>{{$request -> value}}</td>
                    <td>{{$request -> status}}</td>

                </tr>
                @endif
                @endforeach
            </tbody>
        </table>
    </div>
</body>

</html>
@endsection