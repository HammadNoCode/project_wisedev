<?php

namespace App\Http\Controllers\CQC\Carehome;

use App\Http\Controllers\Controller;
use App\Models\CQC\Carehome\Onboarding;
use App\Models\CQC\Carehome\Onboarding\CompletedStages;
use Illuminate\Http\Request;

class OnboardingController extends Controller
{
    public function store($carehome, $id)
    {
        (new CompletedStages())->create([
            'location_id' => $carehome,
            'stage_id' => $id,
            'checked_by' => session('staff_id'),
        ]);
        return response()->json([
            'message' => 'Stage Checked Off'
        ], 200);
    }

    public function index($carehome)
    {
        $stages = Onboarding::all();
        foreach ($stages as $stage) {
            if ($onboardingStage = CompletedStages::where('location_id', $carehome)->where('stage_id', $stage->id)->first()) {
                $stage->checked = true;
            } else {
                $stage->checked = false;
            }
        }
        return response()->json($stages, 200);
    }

    public function destroy($carehome, $id)
    {
        CompletedStages::where('location_id', $carehome)->where('stage_id', $id)->delete();
        return response()->json([
            'message' => 'Unchecked'
        ], 200);
    }
}
