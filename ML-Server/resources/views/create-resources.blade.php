@extends('headers.admin-header')
@section('page')
<!DOCTYPE html>
<html>
<link href="{{ asset('css/app.css') }}" rel="stylesheet" type="text/css">

<header>

</header>

<body>
    <div class="resource-group">
        <form class="resource-group-form" action="/createresourcegroup" method="POST">
            @csrf
            <label for="resource_group"> Resource group name: </label>
            <input type="text" placeholder="Resource group" name="resource_group">


            <button type="submit"> Create resource group </button>

        </form>
    </div>
    <div class="resource">
        <form class="resource-form" action="/createresource" method="POST">
            @csrf
            <label for="resource_group"> Resource group:</label>
            <select name="resource_group">
                @foreach ($resource_group as $resource_group_member)
                <option value="{{$resource_group_member->id}}">{{$resource_group_member->resource_group}}</option>
                @endforeach
            </select>

            <label for="name"> Resource</label>
            <input type="text" placeholder="Resource" name="name">

            <label for="value"> Credit cost:</label>
            <input type="number" min="10" max="200" placeholder="Cost" name="value">



            <button type="submit"> Create resource</button>

        </form>
    </div>
</body>

</html>
@endsection