<?php

namespace App\Http\Controllers\Staff\Recruitment;

use App\Models\Staff\Recruitment\{Log};
use App\Http\Controllers\Controller;

class LogsController extends Controller
{
    /**
     * Show function
     *
     * @param int $id
     * @return void
     */
    public function show($id)
    {
        $logs = Log::where('applicant_id', $id)->orderBy('id', 'desc')
            ->select(
                'staff_id as staff_name',
                'message',
                'updated_at as action_date'
            )
            ->paginate(15);
        return response()->json($logs, 200);
    }
}
