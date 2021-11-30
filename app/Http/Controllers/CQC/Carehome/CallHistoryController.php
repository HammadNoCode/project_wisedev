<?php

namespace App\Http\Controllers\CQC\Carehome;

use App\Http\Controllers\Controller;
use App\Models\CQC\Carehome\CallHistory;
use Illuminate\Http\Request;

class CallHistoryController extends Controller
{
    public function store($id)
    {
        (new CallHistory())->createCallRecord($id);
        return response()->json([
            'message' => 'Call Recorded'
        ], 201);
    }

    public function index($id)
    {
        $data = CallHistory::where('location_id', $id)
            ->paginate(10);
        return response()->json($data, 200);
    }

    public function update(Request $request, $id)
    {
        $record = CallHistory::where('id', $id)->firstOrFail();
        $record->update([
            'spoke_to' => $request->spoke_to,
            'position' => $request->position,
            'decision_maker' => $request->decision_maker,
            'notes' => $request->notes,
        ]);
        return response()->json([
            'message' => 'Record Updated'
        ], 200);
    }
}
