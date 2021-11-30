<?php

namespace App\Http\Controllers\Staff\LiveStaff;

use App\Http\Controllers\Controller;
use App\Models\Staff\Recruitment\Application;
use App\Models\Staff\Recruitment\Application\{Upload as Photo, Profile as AboutMe};
use App\Models\Staff\User\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

use PDF;

class ProfileController extends Controller
{
    /**
     * Get staff application details
     *
     * @param Request $request
     * @return void
     */
    public function getStaff(Request $request)
    {
        $live_staff = Application::test()->where('hired', 1)->where('first_name', $request->staffName)->get();
        return response()->json($live_staff, 200);
    }

    /**
     * Rerieve applicants compliance
     *
     * @param int $staffID
     * @param int $view
     * @return void
     */
    public function document_data($staffID, $view = null)
    {
        $data = Application::where('id', $staffID)
            ->select('id', 'first_name', 'last_name', 'address_line_1', 'city', 'postcode', 'nurse_pin_number')
            ->with('dbs_details', 'about_me', 'profile_picture', 'training.compliance')
            ->get();
        return $data;
    }

    /**
     * Create a pdf
     *
     * @param int $staffID
     * @return void
     */
    public function create_pdf($staffID)
    {
        $data = $this->document_data($staffID, 'pdf');
        $staff = $this->document_data($staffID, 'pdf')->first();
        $html = view('/pdf/staffProfile')->with('nurse_data', $data)->render();
        return PDF::loadHtml($html)->setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true])->setPaper('a4', 'portrait')->download('Staff-' . $staff->first_name . '_' . $staff->last_name . '.pdf');
    }
}
