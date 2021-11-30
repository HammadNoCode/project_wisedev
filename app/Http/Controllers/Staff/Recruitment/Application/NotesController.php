<?php

namespace App\Http\Controllers\Staff\Recruitment\Application;

use App\Models\Staff\Recruitment\{Application};
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Staff\Recruitment\Application\Notes;

class NotesController extends Controller
{
    /**
     * Store notes
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
     * Show notes
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
