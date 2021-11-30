<?php

namespace App\Http\Controllers\Staff\Compliance;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Staff\Recruitment\{Application, Compliance};
use App\Models\Staff\User\User;

class MatrixController extends Controller
{

    public static function env()
    {
        return (bool) User::whereId(session('staff_id'))->value('test');
    }

    public function get_documents()
    {
        return Compliance::get();
    }

    public function show(Request $request)
    {
        $data = Application::where('test', $this->env())
            ->status($request->filter)
            ->branch($request->sort)
            ->position($request->position)
            ->search($request->search)
            ->withCount(['completed_two_reference', 'completed_induction_attendance', 'completed_mandatory_training', 'completed_dbs_check', 'completed_nurse_pin', 'completed_right_to_work', 'completed_proof_of_address'])
            ->withCount('total_compliance_items')
            ->orderBy('created_at', 'desc')
            ->paginate(15);
        return response()->json($data, 200);
    }
}
