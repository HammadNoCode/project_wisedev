<?php

namespace App\Http\Controllers\Compliance\Dashboard;

use App\Models\Compliance\Document\Audit as File;
use App\Http\Controllers\Controller;
use App\Models\Compliance\CompletedAudit\Upload as Audit;
use App\Models\Staff\User\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{

    public function get_clinical_staff()
    {
        return User::select('id', 'name')->get();
    }

    public function time_range($search)
    {
        switch ($search) {
            case 'daily':
                return [
                    'current' => Carbon::now()->startOfDay(),
                    'last' => [
                        'greater_than' => Carbon::now()->startOfDay()->subDay(),
                        'less_than' => Carbon::now()->subDay(),
                    ]
                ];
                break;
            case 'weekly':
                return [
                    'current' => Carbon::now()->startOfWeek(),
                    'last' => [
                        'greater_than' => Carbon::now()->startOfWeek()->subWeek(),
                        'less_than' => Carbon::now()->subWeek(),
                    ]
                ];
                break;
            case 'monthly':
                return [
                    'current' => Carbon::now()->startOfMonth(),
                    'last' => [
                        'greater_than' => Carbon::now()->startOfMonth()->subMonth(),
                        'less_than' => Carbon::now()->subMonth(),
                    ]
                ];
                break;
            default:
                return $this->time_range('daily');
                break;
        }
    }

    public function all_audits()
    {
        $model = File::count();
        return response()->json($model, 200);
    }

    public function completed_audits($query, $filter, $range_1, $range_2 = null)
    {
        $model = Audit::where('created_at', '>', $range_1)->where('staff_id', session('staff_id'));
        if ($range_2) {
            $model = $model->where('created_at', '<=', $range_2);
        }
        switch (true) {
            case $filter > 0:
                $model->where('staff_id', $filter);
                break;
            default:
                break;
        }
        switch ($query) {
            case 'completed':
                // return (int) DB::table('audits_completed')->where('staff_id', session('staff_id'))->groupBy('staff_id')->distinct('audit_id')->count();
                // return (int) $model->distinct('staff_id')->count('audit_id');
                // return (int) $model->select('*')->distinct('audit_id')->groupBy('staff_id')->count();
                return (int) $model->select('*')->count();
            default:
                return 0;
        }
    }

    public function get_query($period, $filter, $query)
    {
        $range = $this->time_range($period);
        $first = $this->completed_audits($query, $filter, $range['current']);
        $second = $this->completed_audits($query, $filter, $range['last']['greater_than'], $range['last']['less_than']);
        return response()->json([
            'current' => $first,
            'last' => $second,
        ], 200);
    }

    public function completion_percentage()
    {
        $all = File::count();
        $completed = Audit::where('staff_id', session('staff_id'))->count();
        $completion_rate = ($completed / $all) * 100;
        return number_format((float) $completion_rate, 2, '.', '');
    }
}
