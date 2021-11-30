<?php

namespace App\Http\Controllers\Staff\Business\Client;

use App\Models\Staff\User\User;
use App\Http\Controllers\Controller;
use App\Models\Staff\Business\Contacts;
use App\Models\Staff\Business\Actions;
use Illuminate\Http\Request;

class ActionController extends Controller
{
    public static function env()
    {
        return (bool) User::whereId(session('staff_id'))->value('test');
    }

    public function store(Request $request, $id)
    {
        $action = (new Actions())->create([
            'client_id' => $id,
            'name' => $request->name,
            'assigned_to' => $request->staff_id,
            'deadline' => $request->deadline,
            'test' => $this->env(),
        ]);
        return response()->json(['message' => 'Action created'], 201);
    }

    public function show($id)
    {
        $actions = Actions::where('client_id', $id)->select('*', 'assigned_to as staff_name')->get();
        return response()->json($actions, 200);
    }

    public function update(Request $request, $id)
    {
        $action = Actions::where('id', $id)->firstOrFail();
        $action->update($request->all());
        return response()->json(['message' => 'Action updated'], 200);
    }

    public function destroy($id)
    {
        Actions::where('id', $id)->delete();
        return response()->json(['message' => 'Action deleted'], 200);
    }
}
