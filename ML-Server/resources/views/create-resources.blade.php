@extends('headers.admin-header')
@section('page')
<!DOCTYPE html>
<html>
<link href="{{ asset('css/app.css') }}" rel="stylesheet" type="text/css">
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<header>

</header>

<body>
    <div class="resource-group">
        <form class="resource-group-form" action="/createresourcegroup" method="POST">
            @csrf
            <label for="resource_group"> Resource group name: </label>
            <input type="text" placeholder="Resource group" name="resource_group" required>


            <button type="submit"> Create resource group </button>

        </form>
    </div>
    <div class="resource">
        <form class="resource-form"  method="POST" action="/createresource">
            @csrf
            <label for="resource_group"> Resource group:</label>
            <select name="resource_group" id = "resources-select">
                <option value = "" disabled selected>Choose an option</option>
                @foreach ($resource_group as $resource_group_member)
                <option value="{{$resource_group_member->id}}">{{$resource_group_member->resource_group}}</option>
                @endforeach
            </select>
            <label for="name"> Resource</label>
            <input type="text" placeholder="Resource" name="name" required>

            <label for = "threshold"> Threshold(GPU Only):</label>
            <input type = "number" min = "1" max = "100" placeholder="Threshold" name  = "threshold">

            <label for="value"> Credit cost(per hour):</label>
            <input type="number" min="10" max="200" placeholder="Cost" name="value" required>



            <button type="submit"> Create resource</button>

        </form>
    </div>

    <div class="change-resources">
        <table class="resources-table">
                <thead>
                <tr>
                    <th>Resource Group</th>
                    <th>Resource</th>
                    <th>Cost</th>
                    <th>Change Status</th>
                    <th>Delete</th>
                </tr>

                </thead>
                <tbody>
                @foreach ($resources as $resource )
                <tr>
                    <td>{{$resource-> resource_group_name}}</td>
                    <td>{{$resource-> name}}</td>
                    <td>{{$resource-> cost}}</td>
                    <td>
                        <form action="admin/resource/change-status/{{$resource->id}}" method="post">
                            @csrf
                            <button type="submit">{{$resource->is_enabled? 'Disable' : 'Enable'}}</button>
                        </form>

                    </td>
                    <td>
                        <form action="admin/resource/delete/{{$resource->id}}" method="post">
                            @csrf
                            <button type="submit">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
                </tbody>
        </table>
    </div>
</body>

</html>



@endsection