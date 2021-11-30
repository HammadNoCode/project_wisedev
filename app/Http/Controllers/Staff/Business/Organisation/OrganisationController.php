<?php

namespace App\Http\Controllers\Staff\Business\Organisation;

use App\Models\Staff\Business\Organisation;
use App\Models\Staff\User\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\Business\Organisation\StoreRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Validator, Mail};

class OrganisationController extends Controller
{
    public static function env()
    {
        return (bool) User::whereId(session('staff_id'))->value('test');
    }

    public function store(StoreRequest $request)
    {
        $client = (new Organisation())->create($request->all());
        return response()->json(['message' => 'Organisation created'], 201);
    }

    public function show(Request $request)
    {
        $searched = $this->search($request->search);
        $organisations = $searched->where('test', $this->env())->with('clients')->paginate(10);
        return response()->json($organisations, 200);
    }

    public function search($search)
    {
        return Organisation::where(function ($query) use ($search) {
            $query->orWhere("name", 'LIKE', "%{$search}%");
            $query->orWhere("email", 'LIKE', "%{$search}%");
            $query->orWhere("city", 'LIKE', "%{$search}%");
            $query->orWhere("county", 'LIKE', "%{$search}%");
            $query->orWhere("postcode", 'LIKE', "%{$search}%");
        });
    }
}
