<?php

namespace App\Http\Controllers\Staff\Business\Client;

use App\Models\Staff\Business\Client;
use App\Models\Staff\User\User;
use App\Http\Controllers\Controller;
use App\Models\Staff\Business\Organisation;
use App\Http\Requests\Business\Client\StoreRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Validator, Mail};

class ClientController extends Controller
{
    public static function env()
    {
        return (bool) User::whereId(session('staff_id'))->value('test');
    }

    public function get_organisations()
    {
        return response()->json(Organisation::all(), 200);
    }

    public function store(StoreRequest $request)
    {
        $client = (new Client())->create($request->all());
        return response()->json(['message' => 'Client created'], 201);
    }

    public function show(Request $request)
    {
        $filtered = $this->filter($request->filter);
        $searched = $this->search((clone $filtered), $request->search);
        $clients = $searched->where('test', $this->env())->select('*', 'group_id as group_name')->paginate(10);
        return response()->json($clients, 200);
    }

    public function filter($filter)
    {
        if ($filter == 'all') {
            return new Client();
        }
        return Client::where('group_id', $filter);
    }

    public function search($client, $search)
    {
        return $client->where(function ($query) use ($search) {
            $query->orWhere("name", 'LIKE', "%{$search}%");
            $query->orWhere("email", 'LIKE', "%{$search}%");
            $query->orWhere("city", 'LIKE', "%{$search}%");
            $query->orWhere("county", 'LIKE', "%{$search}%");
            $query->orWhere("postcode", 'LIKE', "%{$search}%");
        });
    }

    public function destroy($id)
    {
        $client = Client::where('id', $id)->delete();
        return response()->json(['message' => 'Client has been deleted'], 200);
    }
}
