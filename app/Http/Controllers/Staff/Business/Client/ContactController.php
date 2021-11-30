<?php

namespace App\Http\Controllers\Staff\Business\Client;

use App\Models\Staff\User\User;
use App\Http\Controllers\Controller;
use App\Models\Staff\Business\Contacts;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public static function env()
    {
        return (bool) User::whereId(session('staff_id'))->value('test');
    }

    public function store(Request $request, $id)
    {
        $contact = (new Contacts())->create([
            'client_id' => $id,
            'name' => $request->name,
            'type' => $request->type,
            'phone' => $request->phone,
            'email' => $request->email,
            'test' => $this->env(),
        ]);
        return response()->json(['message' => 'Contact created'], 201);
    }

    public function show($id)
    {
        $contacts = Contacts::where('client_id', $id)->get();
        return response()->json($contacts, 200);
    }

    public function update(Request $request, $id)
    {
        $contact = Contacts::where('id', $id)->firstOrFail();
        $contact->update($request->all());
        return response()->json(['message' => 'Contact updated'], 200);
    }

    public function destroy($id)
    {
        Contacts::whereId($id)->delete();
        return response()->json(['message' => 'Contact has been deleted'], 200);
    }
}
