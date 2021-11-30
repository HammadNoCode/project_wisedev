<?php

namespace App\Http\Controllers\CQC\Carehome;

use App\Http\Controllers\Controller;
use App\Models\CQC\Carehome\Contact;
use Illuminate\Http\Request;

class ContactsController extends Controller
{
    public function index($id)
    {
        $data = Contact::where('location_id', $id)->get();
        return response()->json($data, 200);
    }
}
