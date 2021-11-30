<?php

namespace App\Http\Controllers\Staff\Management;

use App\Models\Staff\User\User as Staff;
use App\Http\Controllers\Controller;

class ManagementController extends Controller
{
    public function is_manager()
    {
        $user = Staff::where('id', session('staff_id'))->where('manager', 1)->first();
        if (!$user) {
            return false;
        }
        return true;
    }
    public function read_manager()
    {
        return response()->json(['manager' => $this->is_manager()]);
    }
}
