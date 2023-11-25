@extends('headers.user-header')
@section('page')
<!DOCTYPE html>
<html>
<link href="{{ asset('css/app.css') }}" rel="stylesheet" type="text/css">

<header>

</header>

<body>
    <div class="bookings-request">
        <form class="bookings-form" action="/bookings" method="POST">
            @csrf
            <label for="resource_group">Select Resource Group:</label>
            <select id="resource_group" name="resource_group" onchange="updateResources()">
            @foreach ($resource_groups as $resource_group )
            <option value = "{{ $resource_group->id }}">{{$resource_group -> resource_group}}</option>   
            @endforeach
            </select>
            <label for="resource">Select Resource:</label>
            <select id="resource" name="resource">

            </select>
            <label for="start">Start</label>
            <input type="date" id="start_date" name="start_date" required>
            <select id  = "start_time" name  = "start_time">
                <option value = 00> 00 </option>
                <option value = 01> 01 </option>
                <option value = 02> 02 </option>
                <option value = 03> 03 </option>
                <option value = 04> 04 </option>
                <option value = 05> 05 </option>
                <option value = 06> 06 </option>
                <option value = 07> 07 </option>
                <option value = 08> 08 </option>
                <option value = 09> 09 </option>
                <option value = 10> 10 </option>
                <option value = 11> 11 </option>
                <option value = 12> 12 </option>
                <option value = 13> 13 </option>
                <option value = 14> 14 </option>
                <option value = 15> 15 </option>
                <option value = 16> 16 </option>
                <option value = 17> 17 </option>
                <option value = 18> 18 </option>
                <option value = 19> 19 </option>
                <option value = 20> 20 </option>
                <option value = 21> 21 </option>
                <option value = 22> 22 </option>
                <option value = 23> 23 </option>

            </select>

            <label for="end_day">End</label>
            <input type="date" id="end_date" name="end_date" required>
            
            <select id  = "end_time" name  = "end_time">
            <option value = 00> 00 </option>
                <option value = 01> 01 </option>
                <option value = 02> 02 </option>
                <option value = 03> 03 </option>
                <option value = 04> 04 </option>
                <option value = 05> 05 </option>
                <option value = 06> 06 </option>
                <option value = 07> 07 </option>
                <option value = 08> 08 </option>
                <option value = 09> 09 </option>
                <option value = 10> 10 </option>
                <option value = 11> 11 </option>
                <option value = 12> 12 </option>
                <option value = 13> 13 </option>
                <option value = 14> 14 </option>
                <option value = 15> 15 </option>
                <option value = 16> 16 </option>
                <option value = 17> 17 </option>
                <option value = 18> 18 </option>
                <option value = 19> 19 </option>
                <option value = 20> 20 </option>
                <option value = 21> 21 </option>
                <option value = 22> 22 </option>
                <option value = 23> 23 </option>
            </select>

            <label for="notes"> Notes </label>
            <input type="text-box" placeholder="Notes" name="notes">

       
        <button type=" submit">Submit</button>


        </form>
    </div>

    <script>
        function updateResources() {
            var selectedGroupId = document.getElementById('resource_group').value;
            var resourceSelect = document.getElementById('resource');

            resourceSelect.innerHTML = '';

            fetch('/get-resources-by-group?group_id=' + selectedGroupId)
                .then(response => response.json())
                .then(data => {
                    data.forEach(resource => {
                        addOption(resourceSelect, resource.id, resource.name);
                    });
                })
                .catch(error => console.error('Error:', error));
        }

        function addOption(selectElement, value, text) {
            var option = document.createElement('option');
            option.value = value;
            option.text = text;
            selectElement.add(option);
        }
        updateResources();
    </script>
</body>

</html>
@endsection