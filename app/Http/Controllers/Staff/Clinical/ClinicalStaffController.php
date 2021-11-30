<?php

namespace App\Http\Controllers\Staff\Clinical;

use App\Models\Staff\Clinical\ClinicalStaff;
use App\Models\Staff\User\{User, Branches};
use App\Models\Staff\Recruitment\{Application, Log};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Validator, Mail};
use App\Http\Controllers\Controller;

class ClinicalStaffController extends Controller
{
    const LIVE = true;
    const TEST_EMAIL = 'isaac@warrantywise.co.uk';
    const TEST_MOBILE = null;

    public static function env()
    {
        return (bool) User::whereId(session('staff_id'))->value('test');
    }

    public function index(Request $request)
    {
        $data = ClinicalStaff::where('test', $this->env())
            ->branch($request->filter)
            ->active($request->active)
            ->sort($request->sort)
            ->search($request->search)
            ->orderBy('created_at', 'desc')
            ->select('id', 'staff_id', 'hired_by', 'hired_by as staff_name', 'active')
            ->with('application', 'latest_test', 'vaccination')
            ->paginate(15);
        return response()->json($data, 200);
    }

    public function update($id, Request $request)
    {
        $staff = ClinicalStaff::where('id', $id)->first();
        $staff->update([
            'active' => $request->active
        ]);
        return response()->json([
            'message' => 'Sucess'
        ], 200);
    }

    public function destroy($id)
    {
        ClinicalStaff::where('staff_id', $id)->delete();
        Application::where('id', $id)->update([
            'status' => null,
            'hired' => null
        ]);
        return response()->json([
            'message' => 'Clinical Staff Removed'
        ], 200);
    }
}
