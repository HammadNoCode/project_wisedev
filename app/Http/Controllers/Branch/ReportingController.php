<?php

namespace App\Http\Controllers\Branch;

use App\Http\Controllers\Controller;
use App\Models\Branch\Report;
use App\Models\Staff\Recruitment\Application;
use App\Models\Staff\User\Branches;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

class ReportingController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       // dd($request->all());
        $report = (new Report())->createReport($request);
        return response()->json(['message' => 'Report saved'], 201);
    }

    /**
     * Compares hours gained against hours lost
     * Displayable data must be type int
     *
     * @param Request $request
     * @return void
     */
    public function pie_chart(Request $request)
    {
        //dd($request->all());
        $hours_achieved = 0;
        $hours_lost = 0;
        $s = Branches::where('name', $request->input('branch'))->first();
        $model = Report::where('branch_id', $s['id'])->filterByDate($request->period, $request->date_from, $request->date_to)->get();
        $s = Branches::where('name', $request->input('branch'))->first();
        if ($request->position == 'all') {
            $hours_achieved = $model->sum('hours_achieved');
            $hours_lost = $model->sum('hours_lost');
        } else {
            $hours_achieved = $model->where('position', $request->position)->sum('hours_achieved');
            $hours_lost = $model->where('position', $request->position)->sum('hours_lost');
        }

        $series = [(int) $hours_achieved, (int) $hours_lost];

        return response()->json($series, 200);
    }

    /**
     * Undocumented function
     *
     * @param Request $request
     * @return void
     */
    public function pipeline_hours(Request $request)
    {
        switch ($request->branch) {
            case ('liverpool'):
                $branch = 2;
                break;
            case ('manchester'):
                $branch = 3;
                break;
            default:
                $branch = 2;
                break;
        }
        $hours = Application::where('hired', null)
            ->where('status', 1)
            ->where('test', 0)
            ->position($request->position)
            ->branch($branch)
            ->with('total_compliance_items', function ($query) {
                $query->whereHas('compliance', function ($query) {
                    $query->where('type', 1);
                });
            })
            ->withCount(['total_compliance_items' => function (Builder $query) {
                $query->whereHas('compliance', function ($query) {
                    $query->where('type', 1);
                });
            }])
            ->sum('hours_pw');

        return response()->json($hours, 200);
    }
}
