<?php

namespace App\Http\Controllers\Staff\Business\Client;

use App\Models\Staff\User\User;
use App\Http\Controllers\Controller;
use App\Models\Staff\Business\Communications;
use Illuminate\Http\Request;

class CommunicationController extends Controller
{
    public static function env()
    {
        return (bool) User::whereId(session('staff_id'))->value('test');
    }

    public function store(Request $request, $id)
    {
        $communication = (new Communications())->create([
            'client_id' => $id,
            'contact_id' => $request->contact_id,
            'date' => $request->date,
            'time' => $request->time,
            'notes' => $request->notes,
            'test' => $this->env(),
        ]);
        return response()->json(['message' => 'Conversation recorded'], 201);
    }

    public function show($id)
    {
        $Communications = Communications::where('client_id', $id)->select('*', 'contact_id as contact_name', 'date')->paginate(10);
        return response()->json($Communications, 200);
    }

    public function update(Request $request, $id)
    {
        $Communication = Communications::where('id', $id)->firstOrFail();
        $Communication->update($request->all());
        return response()->json(['message' => 'Conversation updated'], 200);
    }

    public function destroy($id)
    {
        Communications::whereId($id)->delete();
        return response()->json(['message' => 'Conversation deleted'], 200);
    }
}
