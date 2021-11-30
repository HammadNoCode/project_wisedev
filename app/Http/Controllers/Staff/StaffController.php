<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Staff\User\User;
use App\Models\Staff\User\Department;

class StaffController extends Controller
{
    public function show()
    {
        return view('staff.app');
    }

    public function departmentStaff()
    {
        $user = User::find(session('staff_id'));
        if ($user->manager) {
            return ($user->department == 0) ? response()->json(Department::has('staff')->with('staff')->get(), 200) : response()->json(Department::whereId($user->department)->with('staff')->get(), 200);
        } else {
            $department = Department::whereId($user->department)->with('staff')->first();
            return response()->json(['name' => $department->name, 'staff' => [$user]], 200);
        }
    }
}
