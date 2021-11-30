<?php

namespace App\Http\Controllers\Staff\Recruitment\Compliance;

use App\Http\Controllers\Controller;
use App\Models\Staff\Compliance\Notes;
use Illuminate\Http\Request;

class NotesController extends Controller
{
    /**
     * Store compliance notes
     *
     * @param Request $request
     * @param int $id
     * @return void
     */
    public function create_note(Request $request, $id)
    {
        $note = (new Notes())->createNote($request, $id);
        return response()->json([
            'message' => 'note created'
        ], 201);
    }

    /**
     * Show compliance notes
     *
     * @param int $id
     * @return void
     */
    public function read_notes($id)
    {
        $notes = Notes::where('applicant_id', $id)->orderBy('created_at', 'desc')->paginate(5);
        return response()->json($notes, 200);
    }
}
