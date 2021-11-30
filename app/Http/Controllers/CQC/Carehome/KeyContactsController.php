<?php

namespace App\Http\Controllers\CQC\Carehome;

use App\Http\Controllers\Controller;
use App\Models\CQC\Carehome\KeyContact;
use Illuminate\Http\Request;

class KeyContactsController extends Controller
{
    public function store(Request $request, $id)
    {
        (new KeyContact())->createKeyContact($id, $request);
        return response()->json([
            'message' => 'Contact saved'
        ], 201);
    }

    public function index($id) 
    {
        $keyContacts = KeyContact::where('location_id', $id)->get();
        return response()->json($keyContacts, 200);
    }
}
