<?php

namespace App\Http\Controllers\Staff\Business\Client;

use App\Models\Staff\User\User;
use App\Http\Controllers\Controller;
use App\Models\Staff\Business\Notes;
use Illuminate\Http\Request;

class NotesController extends Controller
{
    public static function env()
    {
        return (bool) User::whereId(session('staff_id'))->value('test');
    }

    public function store(Request $request, $id)
    {
        $contact = (new Notes())->create([
            'client_id' => $id,
            'staff_id' => session('staff_id'),
            'notes' => $request->notes,
            'test' => $this->env(),
        ]);
        return response()->json(['message' => 'Note saved'], 201);
    }

    public function show($id)
    {
        $notes = Notes::where('client_id', $id)->where('deleted', 0)->select('*', 'staff_id as staff_name')->paginate(5);
        return response()->json($notes, 200);
    }

    public function destroy($id)
    {
        Notes::where('id', $id)->update(['deleted' => 1]);
        return response()->json(['message' => 'Note deleted'], 200);
    }
}
