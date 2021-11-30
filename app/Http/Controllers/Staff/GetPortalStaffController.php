<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Staff\Recruitment\Application;

class GetPortalStaffController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke()
    {
        $staff = Application::where('hired', 1)->where('test', 1)->orderBy('first_name', 'asc')->get();
        return response()->json($staff, 200);
    }
}
