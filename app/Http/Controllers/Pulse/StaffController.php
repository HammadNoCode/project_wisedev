<?php

namespace App\Http\Controllers\Pulse;

use App\Models\Staff\User\{User, Branches};
use App\Http\Controllers\Controller;
use App\Models\Pulse\Staff;
use App\Models\Staff\Clinical\ClinicalStaff;
use Illuminate\Http\Request;

class StaffController extends Controller
{
    const LIVE = true;
    const TEST_EMAIL = 'isaac@warrantywise.co.uk';
    const TEST_MOBILE = null;

    public static function env()
    {
        return (bool) User::whereId(session('staff_id'))->value('test');
    }

    public function show(Request $request)
    {
        $filtered = $this->filter($request->filter);
        $staff = $filtered->select('*')->with('application')->where('deleted', 0)->orderBy('first_name', 'asc')->paginate(15);
        return response()->json($staff, 200);
    }

    public function filter($filter)
    {
        if ($filter == 'all') {
            return new Staff();
        }
        if ($filter == '0') {
            return Staff::whereHas('application');
        }
        if ($filter == '1') {
            return Staff::doesntHave('application');
        }
    }

    public function destroy($id)
    {
        Staff::where('id', $id)->update(['deleted' => 1]);
        return response()->json(['messgae' => 'Staff record deleted'], 200);
    }

    public function update_contacted()
    {
        $duplicate = ClinicalStaff::where('contacted', 1)->get();
        echo count($duplicate) . "\n";

        foreach ($duplicate as $staff) {
            ClinicalStaff::where('staff_id', $staff->staff_id)->update(['contacted' => 0]);
        }
    }
}
