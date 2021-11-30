<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Staff\Business\Contacts;
use Illuminate\Http\Request;

class GetContactsController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, $id)
    {
        $contacts = Contacts::where('client_id', $id)->get();
        return response()->json($contacts, 200);
    }
}
