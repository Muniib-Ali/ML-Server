<?php

namespace App\Http\Controllers;

use App\Models\Resource;
use App\Models\ResourceGroup;
use Illuminate\Http\Request;

class BookingsController extends Controller
{
    public function show(){

        $resource_groups = ResourceGroup::all();
        $resources = Resource::all();
        return view('bookings', ['resource_groups' => $resource_groups], ['resources' => $resources]);
    }

    public function getResourcesByGroup(Request $request)
    {
        $groupId = $request->input('group_id');
        $resources = Resource::where('resource_group_id', $groupId)->get();

        return response()->json($resources);
    }
}
