<?php

namespace App\Http\Controllers\CQC\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\CQC\Carehome;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

class PieController extends Controller
{
    public function pie_chart_query(Request $request)
    {
        $model = new Carehome();
        $notContacted = [];
        $usingCavalry = [];
        $onboarding = [];
        if ($request->branch == "all") {
            $notContacted = $model->whereDoesntHave('notContacted')->count();
            $onboarding = $model->whereHas('onboarding')->count();
            $usingCavalry = $model->whereHas('agencies', function (Builder $query) {
                $query->where('name', 'Cavalrycare')->orWhere('name', 'Cavalry Healthcare')->orWhere('name', 'Cavalry');
            })->count();
        } else {
            $notContacted = $model->where('branch_id', $request->branch)->whereDoesntHave('notContacted')->count();
            $onboarding = $model->where('branch_id', $request->branch)->whereHas('onboarding')->count();
            $usingCavalry = $model->where('branch_id', $request->branch)->whereHas('agencies', function (Builder $query) {
                $query->where('name', 'Cavalrycare')->orWhere('name', 'Cavalry Healthcare')->orWhere('name', 'Cavalry');
            })->count();
        }
        $labels = ['Not Contacted', 'Started to Onboard', 'Using Cavalry'];
        $series = [$notContacted, $onboarding, $usingCavalry];
        return response()->json([
            'labels' => $labels,
            'series' => $series,
        ], 200);
    }
}
