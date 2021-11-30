<?php

namespace App\Http\Controllers\CQC\Carehome;

use App\Http\Controllers\Controller;
use App\Models\CQC\Carehome\Notes;
use Illuminate\Http\Request;

class NotesController extends Controller
{
    public function store(Request $request, $id)
    {
        $note = (new Notes())->createNote($request, $id);
        return response()->json([
            'message' => 'note created'
        ], 201);
    }

    public function index($id)
    {
        $notes = Notes::where('location_id', $id)->where('deleted', 0)->orderBy('created_at', 'desc')->paginate(5);
        return response()->json($notes, 200);
    }

    public function soft_destroy($id)
    {
        Notes::where('id', $id)->update(['deleted' => 1]);
        return response()->json(['message' => 'Note deleted'], 200);
    }
}
