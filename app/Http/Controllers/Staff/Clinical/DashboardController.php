<?php

namespace App\Http\Controllers\Staff\Clinical;

use App\Models\Staff\Recruitment\{Application, Reference, Interview};
use App\Models\Staff\User\{Branches, User};
use App\Http\Controllers\Controller;
use App\Models\Staff\Clinical\ClinicalStaff;
use Carbon\Carbon;
use Composer\DependencyResolver\Request;
use PhpParser\Builder\Interface_;

class DashboardController extends Controller
{
    public function table_model($table, $query, $branch)
    {
        switch ($table) {
            case 'clinical':
                $model = Application::where('hired', 1)->whereTest(0);
                switch (true) {
                    case $branch > 0:
                        $model->where('branch_id', $branch);
                        break;
                    default:
                        break;
                }
                switch ($query) {
                    case 'ha':
                        return (int) $model->wherePosition('healthcare assistant')->count();
                    case 'sha':
                        return (int) $model->wherePosition('senior healthcare assistant')->count();
                    case 'rgn':
                        return (int) $model->wherePosition('RGN')->count();
                    case 'rmn':
                        return (int) $model->wherePosition('RMN')->count();
                    case 'sw':
                        return (int) $model->wherePosition('support worker')->count();
                    case 'hire_rate':
                        if ($branch == 0) {
                            $hired = Application::whereIn('hired', ['1'])->whereTest(0)->count();
                            $all = Application::select('*')->whereTest(0)->count();
                            $hire_rate =  100 / ($hired + $all) * $hired;
                            return number_format((float) $hire_rate, 2, '.', '');
                        } else {
                            $hired = Application::whereIn('hired', ['1'])->whereTest(0)->where('branch_id', $branch)->count();
                            $all = Application::select('*')->whereTest(0)->count();
                            $hire_rate =  100 / ($hired + $all) * $hired;
                            return number_format((float) $hire_rate, 2, '.', '');
                        }
                    default:
                        return 0;
                }
        }
    }

    public function get_query($table, $branch, $query)
    {
        $first = $this->table_model($table, $query, $branch);
        $second = $this->table_model($table, $query, $branch);
        return response()->json([
            'current' => $first,
            'last' => $second,
        ], 200);
    }

    public function get_branches()
    {
        return Application::select('position')->whereNotNull('position')->orderBy('position', 'asc')->distinct()->pluck('position');
    }

    public function bar_chart_model()
    {
        $positions = Application::whereHired(1)->whereNotNull('position')->select('position')->orderBy('position', 'asc')->distinct()->pluck('position');

        $blackburn = [];
        $liverpool = [];
        $warrington = [];

        foreach ($positions as $position) {
            array_push($blackburn, Application::whereNotNull('position')->where('position', $position)->whereHired(1)->where('branch_id', 1)->whereTest(0)->count());
            array_push($liverpool, Application::whereNotNull('position')->where('position', $position)->whereHired(1)->where('branch_id', 2)->whereTest(0)->count());
            array_push($warrington, Application::whereNotNull('position')->where('position', $position)->whereHired(1)->where('branch_id', 3)->whereTest(0)->count());
        }
        return [
            [
                'name' => "Blackburn",
                'data' => $blackburn
            ],
            [
                'name' => "Liverpool",
                'data' => $liverpool,
            ],
            [
                'name' => "Warrington",
                'data' => $warrington,
            ]
        ];
    }

    public function bar_chart_query()
    {
        $data = [];
        $data['units'] = $this->get_branches();
        $data['series'] = $this->bar_chart_model();
        return response()->json($data, 200);
    }
}
