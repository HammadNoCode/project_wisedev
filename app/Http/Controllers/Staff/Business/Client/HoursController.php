<?php

namespace App\Http\Controllers\Staff\Business\Client;

use App\Models\Staff\User\User;
use App\Http\Controllers\Controller;
use App\Models\Staff\Business\Hours;
use Illuminate\Http\Request;

class HoursController extends Controller
{
    public static function env()
    {
        return (bool) User::whereId(session('staff_id'))->value('test');
    }

    public function store(Request $request, $id)
    {
        $hours = (new Hours())->create([
            'client_id' => $id,
            'requested_hours' => $request->requested_hours,
            'test' => $this->env(),
        ]);
        return response()->json(['message' => 'Requested hours added'], 201);
    }

    public function show($id)
    {
        $hours = Hours::where('client_id', $id)->where('test', $this->env())->paginate(10);
        return response()->json($hours, 200);
    }

    public function update(Request $request, $id)
    {
        $hours = Hours::where('id', $id)->firstOrFail();
        $hours->update($request->all());
        return response()->json(['message' => 'Hours updated'], 200);
    }

    public function destroy($id)
    {
        Hours::where('id', $id)->delete();
        return response()->json(['message' => 'Hours deleted'], 200);
    }
}
