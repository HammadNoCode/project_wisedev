<?php

namespace App\Http\Controllers\Compliance\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Compliance\CompletedAudit\Upload as Audit;
use App\Models\Staff\User\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TableController extends Controller
{

    public function show_tracker(Request $request)
    {
        $user = User::where('id', session('staff_id'))->firstOrFail();
        if ((int) $user->compliance_manager === 1) {
            $filtered = $this->filter($request->filter);
            $audits = $filtered->with('audit')->orderBy('created_at', 'asc')->groupBy('audit_id')->paginate(10);
        } else {
            $audits = Audit::where('staff_id', session('staff_id'))->with('audit')->groupBy('audit_id')->paginate(10);
        }
        return response()->json($audits, 200);
    }

    public function filter($filter)
    {
        return Audit::where('staff_id', $filter)->select(DB::raw('*, max(created_at)'));
    }
}
