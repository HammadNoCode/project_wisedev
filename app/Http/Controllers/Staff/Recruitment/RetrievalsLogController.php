<?php

namespace App\Http\Controllers\Staff\Recruitment;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Staff\Recruitment\Application;
use App\Models\Staff\Recruitment\RetrievalsLog;
use Carbon\Carbon;

class RetrievalsLogController extends Controller
{
    public function show(Request $request)
    {
        $filtered = $this->filter($request->filter);
        $retrievals = $filtered->select('*')->where('completed', 0)->with('application')->paginate(10);
        return response()->json($retrievals, 200);
    }

    public function filter($filter)
    {
        switch ($filter) {
            case 'newest':
                return RetrievalsLog::orderBy('updated_at', 'desc');
            default:
                return RetrievalsLog::orderBy('updated_at', 'asc');
        }
    }
}
