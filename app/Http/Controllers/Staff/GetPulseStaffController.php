<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Pulse\Staff;
use App\Models\Staff\Recruitment\Application;

class GetPulseStaffController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke()
    {
        $staff = Staff::where('deleted', 0)->orderBy('name', 'asc')->get();
        return response()->json($staff, 200);
    }
}
