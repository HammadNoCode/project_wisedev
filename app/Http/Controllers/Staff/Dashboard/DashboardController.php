<?php

namespace App\Http\Controllers\Staff\Dashboard;

use Illuminate\Support\Facades\DB;
use App\Models\Staff\Recruitment\{Application, Reference, Interview};
use App\Models\Staff\User\{User as Staff};
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Composer\DependencyResolver\Request;
use PhpParser\Builder\Interface_;

class DashboardController extends Controller
{
    public function time_range($search)
    {
        switch ($search) {
            case 'daily':
                return [
                    'this' => Carbon::now()->startOfDay(),
                    'last' => [
                        'greater_than' => Carbon::now()->startOfDay()->subDay(),
                        'less_than' => Carbon::now()->subDay(),
                    ]
                ];
                break;
            case 'weekly':
                return [
                    'this' => Carbon::now()->startOfWeek(),
                    'last' => [
                        'greater_than' => Carbon::now()->startOfWeek()->subWeek(),
                        'less_than' => Carbon::now()->subWeek(),
                    ]
                ];
                break;
            case 'monthly':
                return [
                    'this' => Carbon::now()->startOfMonth(),
                    'last' => [
                        'greater_than' => Carbon::now()->startOfMonth()->subMonth(),
                        'less_than' => Carbon::now()->subMonth(),
                    ]
                ];
                break;
            case 'all-time':
                return [
                    'this' => Carbon::now()->startOfCentury(),
                    'last' => [
                        'greater_than' => Carbon::now()->startOfCentury()->subCentury(),
                        'less_than' => Carbon::now()->subCentury(),
                    ]
                ];
                break;
            default:
                return $this->time_range('daily');
                break;
        }
    }

    public function table_model($table, $query, $filter, $range_1, $range_2 = null)
    {
        switch ($table) {
            case 'application':
                $model = Application::where('created_at', '>', $range_1)->whereTest(0);
                if ($range_2) {
                    $model = $model->where('created_at', '<=', $range_2);
                }
                switch (true) {
                    case $filter != "all":
                        $model->where('branch_id', $filter);
                        break;
                    default:
                        break;
                }
                switch ($query) {
                    case 'total':
                        return (int) $model->whereNotNull('declaration')->count();
                    case 'incomplete':
                        return (int) $model->whereNull('declaration')->count();
                    case 'pending':
                        return (int) $model->whereNotNull('declaration')->whereStatus(null)->count();
                    case 'accepted':
                        return (int) $model->whereStatus(1)->count();
                    case 'live':
                        return (int) $model->whereHired(1)->count();
                    case 'rejected':
                        return (int) $model->whereStatus(2)->count();
                    case 'inexperienced':
                        return (int) $model->whereStatus(3)->count();
                    case 'not_yet':
                        return (int) $model->whereStatus(4)->count();
                    case 'archived':
                        return (int) $model->whereStatus(5)->count();
                    case 'completion_rate':
                        $all = Application::whereNotNull('declaration')->count();
                        $incomplete = $model->where('declaration', null)->count();
                        $completion_rate = 100 / ($all + $incomplete) * $all;
                        return number_format((float) $completion_rate, 2, '.', '');
                    default:
                        return 0;
                }
            case 'interview':
                switch (true) {
                    case $filter != "all":
                        $applicantFilter = Application::where('branch_id', $filter)->pluck('id');
                        break;
                    default:
                        $applicantFilter = false;
                        break;
                }
                $model = Interview::where('updated_at', '>', $range_1)->whereTest(0);
                if ($range_2) {
                    $model = $model->where('updated_at', '<=', $range_2);
                }
                if ($applicantFilter) {
                    $model = $model->whereIn('applicant_id', $applicantFilter);
                }
                switch ($query) {
                    case 'total':
                        return (int) $model->select('*')->count();
                    case 'pending':
                        return (int) $model->whereStatus(0)->count();
                    case 'planned':
                        return (int) $model->whereStatus(1)->count();
                    case 'completed':
                        return (int) $model->whereIn('status', ['2', '3', '4'])->count();
                    case 'percent':
                        $successRate = Interview::whereIn('status', ['3'])
                            ->whereNotIn('staff_id', ['81', '82', '83'])
                            ->whereTest(0)
                            ->count();
                        $total = Interview::whereIn('status', ['4'])
                            ->whereNotIn('staff_id', ['81', '82', '83'])
                            ->whereTest(0)
                            ->count();
                        $percent =  100 / ($successRate + $total) * $successRate;
                        return number_format((float) $percent, 2, '.', '');
                    default:
                        return 0;
                }
            case 'reference':
                switch (true) {
                    case $filter != "all":
                        $applicantFilter = Application::where('branch_id', $filter)->pluck('id');
                        break;
                    default:
                        $applicantFilter = false;
                        break;
                }
                $model = Reference::where('created_at', '>', $range_1)->whereTest(0);
                if ($range_2) {
                    $model = $model->where('created_at', '<=', $range_2);
                }
                if ($applicantFilter) {
                    $model = $model->whereIn('applicant_id', $applicantFilter);
                }
                switch ($query) {
                    case 'total':
                        return (int) $model->select('*')->count();
                    case 'awaiting':
                        return (int) $model->whereStatus(null)->count();
                    case 'pending':
                        return (int) $model->whereStatus(1)->count();
                    case 'completed':
                        return (int) $model->whereStatus(2)->count();
                    case 'rejected':
                        return (int) $model->whereStatus(3)->count();
                    default:
                        return 0;
                }
            default:
                return (object) [];
        }
    }

    public function get_query($table, $period, $filter, $query, $begin_date)
    {
        $range = $this->time_range($period);
        $first = $this->table_model($table, $query, $filter, $range['this']);
        $second = $this->table_model($table, $query, $filter, $range['last']['greater_than'], $range['last']['less_than']);
        return response()->json([
            'this' => $first,
            'last' => $second,
        ], 200);
    }

    public function loop_range($search)
    {
        switch ($search) {
            case 'daily':
                return [
                    'this' => 7,
                    'last' => [
                        'less_than' => 8,
                        'equal_to' => 14,
                    ],
                    'sub' => 'subDays',
                    'format' => 'Y-m-d',
                    'pretty_format_1' => 'D',
                    'pretty_format_2' => 'D',
                    'startOf' => 'startOfDay',
                ];
                break;
            case 'weekly':
                return [
                    'this' => 12,
                    'last' => [
                        'less_than' => 13,
                        'equal_to' => 24,
                    ],
                    'sub' => 'subWeeks',
                    'format' => 'Y-m-d',
                    'pretty_format_1' => 'd/m',
                    'pretty_format_2' => 'd/m/y',
                    'startOf' => 'startOfWeek'
                ];
                break;
            case 'monthly':
                return [
                    'this' => 12,
                    'last' => [
                        'less_than' => 13,
                        'equal_to' => 24,
                    ],
                    'sub' => 'subMonths',
                    'format' => 'Y-m-d',
                    'pretty_format_1' => 'M',
                    'pretty_format_2' => 'm/Y',
                    'startOf' => 'startOfMonth'
                ];
                break;
            default:
                return $this->loop_range('daily');
                break;
        }
    }

    public function get_staff($table, $range_1, $range_2 = null)
    {
        $model = Interview::where('updated_at', '>', $range_1)->where('test', 0)->get();
        if ($range_2) {
            $model = $model->where('updated_at', '<=', $range_2)->where('test', 0)->get();
        }
        $active_staff_ids = $model->where('staff_id', '!=', '')->where('staff_id', '!=', 96)->pluck('staff_id')->toArray();
        $unique_staff_ids = array_unique($active_staff_ids);
        return Staff::whereIn('id', $unique_staff_ids)->pluck('name');
    }

    public function stacked_chart_model($table, $range_1, $range_2 = null)
    {
        $planned = [];
        $completed = [];
        $successful = [];
        $rejected = [];
        $no_show = [];

        $model = Interview::where('updated_at', '>', $range_1)->where('test', 0)->get();
        if ($range_2) {
            $model = $model->where('updated_at', '<=', $range_2)->where('test', 0)->get();
        }

        $active_staff_ids = $model->where('staff_id', '!=', '')->where('staff_id', '!=', 96)->pluck('staff_id')->toArray();
        $unique_staff_ids = array_unique($active_staff_ids);

        foreach ($unique_staff_ids as $id) {
            array_push($planned, $model->where('staff_id', $id)->where('status', 1)->count());
            array_push($completed, $model->where('staff_id', $id)->where('status', 2)->count());
            array_push($successful, $model->where('staff_id', $id)->where('status', 3)->count());
            array_push($rejected, $model->where('staff_id', $id)->where('status', 4)->count());
            array_push($no_show, $model->where('staff_id', $id)->where('status', 5)->count());
        }

        return [
            [
                'name' => "Planned",
                'data' => $planned
            ],
            [
                'name' => "Completed",
                'data' => $completed
            ],
            [
                'name' => "Successful",
                'data' => $successful
            ],
            [
                'name' => "Rejected",
                'data' => $rejected,
            ],
            [
                'name' => "No Show",
                'data' => $no_show
            ],
        ];
    }

    public function stacked_chart_query($table, $period)
    {
        $range = $this->time_range($period);
        $data = [];
        $data['units'] = $this->get_staff($table, $range['this']);
        $data['series'] = $this->stacked_chart_model($table, $range['this']);
        return response()->json($data, 200);
    }

    public function bar_chart_model($table, $query, $filter, $range_1, $range_2 = null)
    {
        switch ($table) {
            default:
                $model_1 = Application::where('created_at', '>', $range_1)->whereTest(0);
                switch (true) {
                    case $filter != "all":
                        $model_1->where('branch_id', $filter);
                        break;
                    default:
                        break;
                }
                $model_2 = Interview::where('created_at', '>', $range_1)->whereTest(0);
                switch (true) {
                    case $filter != "all":
                        $applicantFilter = Application::where('branch_id', $filter)->pluck('id');
                        break;
                    default:
                        $applicantFilter = false;
                        break;
                }
                if ($applicantFilter) {
                    $model = $model_2->whereIn('applicant_id', $applicantFilter);
                }
                $model_3 = Reference::where('created_at', '>', $range_1)->whereTest(0);
                switch (true) {
                    case $filter != "all":
                        $applicantFilter = Application::where('branch_id', $filter)->pluck('id');
                        break;
                    default:
                        $applicantFilter = false;
                        break;
                }
                if ($applicantFilter) {
                    $model = $model_3->whereIn('applicant_id', $applicantFilter);
                }
                if ($range_2) {
                    $model_1 = $model_1->where('created_at', '<=', $range_2);
                    $model_2 = $model_2->where('created_at', '<=', $range_2);
                    $model_3 = $model_3->where('created_at', '<=', $range_2);
                }
                switch ($query) {
                    case 'application':
                        $complete = (int) ((clone $model_1)->whereNotNull('declaration')->count());
                        $incomplete = (int) ((clone $model_1)->whereNull('declaration')->count());
                        return  $complete;
                    case 'interview':
                        return (int) ((clone $model_2)->count());
                    case 'reference':
                        return (int) ((clone $model_3)->count());
                    default:
                        return 0;
                }
                return (object) [];
        }
    }

    public function bar_chart_query($table, $period, $filter, $query)
    {
        $range = $this->loop_range($period);
        $data = [];
        for ($i = $range['this']; $i >= 1; $i--) {
            $data['units'][] = Carbon::now()->{$range['startOf']}()->{$range['sub']}($i)->format($range['pretty_format_2']);
            $model = $this->bar_chart_model($table, $query, $filter, Carbon::now()->{$range['startOf']}()->{$range['sub']}($i), Carbon::now()->{$range['startOf']}()->{$range['sub']}($i - 1));
            $data['series'][0][] = $model;
        }
        return response()->json($data, 200);
    }

    public function pie_chart_model($table, $range_1, $range_2 = null)
    {
        switch ($table) {
            case 'applications':
                $model = Application::where('created_at', '>=', $range_1)->whereTest(0)->whereNotNull('declaration');
                if ($range_2) {
                    $model = $model->where('created_at', '<=', $range_1)->where('created_at', '>=', $range_2);
                }
                return $model;
            default:
                return $this->pie_chart_model('applications', $range_1, $range_2);
        }
    }

    public function pie_chart_query($table, $period, $query)
    {
        $range = $this->time_range($period);
        $model = $this->pie_chart_model($table, $range['this']);
        $series = [];
        $labels = (clone $model)->groupBy($query)->pluck($query);
        foreach ($labels as $key => $label) {
            if ($label == null) {
                $labels[$key] = 'Website';
            }
            $series[] = (clone $model)->where($query, $label)->count();
        }
        return response()->json([
            'labels' => $labels,
            'series' => $series,
        ], 200);
    }
}
