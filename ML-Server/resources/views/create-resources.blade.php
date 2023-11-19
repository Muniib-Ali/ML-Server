@extends('headers.admin-header')
@section('page')
<!DOCTYPE html>
<html>
<header>

</header>

<body>
<form class = "resource-groupcreation-form" action = "/resourcegroup" method = "POST" >
        @csrf
        <label for = "credits"> Resource group name:  </label>
        <input type = "text"  placeholder = "Resource group" name = "resource_group">

        
        <button type = "submit"> Create resource group </button>

    </form>
</body>
</html>
@endsection