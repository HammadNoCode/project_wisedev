<?php

namespace App\Http\Controllers\Staff\Recruitment;

use App\Http\Controllers\Controller;
use App\Models\Staff\Recruitment\Interview;
use App\Models\Staff\User\User;
use Illuminate\Http\Request;

class InterviewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $datatable = Interview::branch($request->branch)
            ->status($request->status)
            ->interviewer($request->staff)
            ->orderBy('id', 'desc')
            ->select(
                'applicant_id',
                'status as response',
                'applicant_id as position',
                'applicant_id as first_name',
                'applicant_id as last_name',
                'applicant_id as application_status',
                'staff_id as staff_name',
                'date as scheduled_date',
                'time as scheduled_time'
            )
            ->paginate(25);
        return response()->json($datatable, 200);
    }

    /**
     * Active interviewers
     *
     * @return void
     */
    public function activeInterviewers()
    {
        $active = Interview::where('staff_id', '!=', '')
            ->distinct()
            ->pluck('staff_id');
        $interviewers = User::whereIn('id', $active)
            ->select('id', 'name')
            ->get();
        return response()->json($interviewers, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $invites = Interview::where('applicant_id', $id)->get();
        return response()->json($invites, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
