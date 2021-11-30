<?php

namespace App\Http\Controllers\Compliance\Templates;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\{Validator, Mail};
use App\Models\Compliance\Document\Group;
use App\Http\Controllers\Controller;
use App\Models\Compliance\Document\Audit;

class GroupsController extends Controller
{
    public function store(Request $request)
    {
        $groups = (new Group())->createGroup($request);
        return response()->json([
            'message' => 'Audit group created'
        ], 201);
    }

    public function show_groups()
    {
        $groups = Group::with('audits')->get();
        return response()->json($groups, 200);
    }

    public function show(Request $request)
    {
        $filtered = $this->filter($request->filter);
        $files = $filtered->get();
        return response()->json($files, 200);
    }

    public function filter($filter)
    {
        return Audit::where('group_id', $filter)->where('deleted', 0);
    }

    public function destroy($id)
    {
        $unassigned = Group::where('name', '=', 'Unassigned')->value('id');
        Audit::where('group_id', $id)->update(['group_id' => $unassigned]);
        Group::whereId($id)->delete();
        return response()->json([
            'message' => 'Audit group deleted'
        ], 200);
    }

    public function clear($id)
    {
        Audit::where('group_id', $id)->delete();
        return response()->json([
            'message' => 'Audit group templates cleared'
        ], 200);
    }
}
