<?php

namespace App\Http\Controllers\CQC\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\CQC\Carehome;
use App\Models\CQC\Carehome\Onboarding\CompletedStages;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;

class StatsController extends Controller
{
    public function carehome_visits_leaderboard(Request $request)
    {
        $model = CompletedStages::where('stage_id', 7)->get();
        if ($model->count() > 0) {
            foreach ($model as $visit) {
                switch ($request->branch) {
                    case ('all'):
                        $blackburn = $visit->where('stage_id', 7)->filterByDate($request->period)->whereHas('blackburnCarehome')->count();
                        $liverpool = $visit->where('stage_id', 7)->filterByDate($request->period)->whereHas('liverpoolCarehome')->count();
                        $warrington = $visit->where('stage_id', 7)->filterByDate($request->period)->whereHas('warringtonCarehome')->count();
                        $crewe = $visit->where('stage_id', 7)->filterByDate($request->period)->whereHas('creweCarehome')->count();
                        return response()->json([
                            'branches' => ['Blackburn', 'Liverpool', 'Warraington', 'Crewe'],
                            'data' => [$blackburn, $liverpool, $warrington, $crewe]
                        ], 200);
                    default: 
                        $branch_id = $request->branch;
                        $data = $visit->where('stage_id', 7)->filterByDate($request->period)->whereHas('carehome', function ($query) use ($branch_id) {
                            $query->where('branch_id', $branch_id);
                        })->count();
                        return response()->json($data, 200);
                }
            }
        } else { 
            return response()->json([
                'branches' => ['Blackburn', 'Liverpool', 'Warraington', 'Crewe'],
                'data' => [0, 0, 0, 0]
            ], 200);
        }
    }

    public function carehome_merchandise_leaderboard(Request $request)
    {
        $model = CompletedStages::where('stage_id', 6)->get();
        if ($model->count() > 0) {
            foreach ($model as $merchandise) {
                switch ($request->branch) {
                    case ('all'):
                        $blackburn = $merchandise->where('stage_id', 6)->filterByDate($request->period)->whereHas('blackburnCarehome')->count();
                        $liverpool = $merchandise->where('stage_id', 6)->filterByDate($request->period)->whereHas('liverpoolCarehome')->count();
                        $warrington = $merchandise->where('stage_id', 6)->filterByDate($request->period)->whereHas('warringtonCarehome')->count();
                        $crewe = $merchandise->where('stage_id', 6)->filterByDate($request->period)->whereHas('creweCarehome')->count();
                        return response()->json([
                            'branches' => ['Blackburn', 'Liverpool', 'Warraington', 'Crewe'],
                            'data' => [$blackburn, $liverpool, $warrington, $crewe]
                        ], 200);
                    default: 
                        $branch_id = $request->branch;
                        $data = $merchandise->where('stage_id', 6)->filterByDate($request->period)->whereHas('carehome', function ($query) use ($branch_id) {
                            $query->where('branch_id', $branch_id);
                        })->count();
                        return response()->json($data, 200);
                }
            }
        } else {
            return response()->json([
                'branches' => ['Blackburn', 'Liverpool', 'Warraington', 'Crewe'],
                'data' => [0, 0, 0, 0]
            ], 200);
        }
    }

    /**
     * Undocumented function
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function carehome_phonecall_leaderboard(Request $request): \Illuminate\Http\JsonResponse
    {
        $callStages = [1, 2, 3, 4];
        $model = CompletedStages::all();
        if ($model->count() > 0) {
            foreach ($model as $phoneCall) {
                switch ($request->branch) {
                    case ('all'):
                        $blackburn = $phoneCall->whereIn('stage_id', $callStages)->filterByDate($request->period)->whereHas('blackburnCarehome')->count();
                        $liverpool = $phoneCall->whereIn('stage_id', $callStages)->filterByDate($request->period)->whereHas('liverpoolCarehome')->count();
                        $warrington = $phoneCall->whereIn('stage_id', $callStages)->filterByDate($request->period)->whereHas('warringtonCarehome')->count();
                        $crewe = $phoneCall->whereIn('stage_id', $callStages)->filterByDate($request->period)->whereHas('creweCarehome')->count();
                        return response()->json([
                            'branches' => ['Blackburn', 'Liverpool', 'Warraington', 'Crewe'],
                            'data' => [$blackburn, $liverpool, $warrington, $crewe]
                        ], 200);
                    default: 
                        $branch_id = $request->branch;
                        $data = $phoneCall->whereIn('stage_id', $callStages)->filterByDate($request->period)->whereHas('carehome', function ($query) use ($branch_id) {
                            $query->where('branch_id', $branch_id);
                        })->count();
                        return response()->json($data, 200);
                }
            }
        } else {
            return response()->json([
                'branches' => ['Blackburn', 'Liverpool', 'Warraington', 'Crewe'],
                'data' => [0, 0, 0, 0]
            ], 200);
        }
    }
}
