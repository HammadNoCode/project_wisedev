<?php

namespace App\Http\Controllers\Staff\Business\Client;

use App\Models\Staff\Business\Client;
use App\Models\Staff\User\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DetailsController extends Controller
{
    public static function env()
    {
        return (bool) User::whereId(session('staff_id'))->value('test');
    }

    public function show($id)
    {
        $client = Client::where('id', $id)->firstOrFail();
        return response()->json($client, 200);
    }

    public function update(Request $request, $id)
    {
        $client = Client::where('id', $id)->firstOrFail();
        $client->update($request->all());
        return response()->json(['message' => 'Client details updated'], 200);
    }
}
