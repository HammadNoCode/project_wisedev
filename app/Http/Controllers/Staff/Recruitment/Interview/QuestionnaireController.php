<?php

namespace App\Http\Controllers\Staff\Recruitment\Interview;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Staff\Recruitment\Application;
use App\Models\Staff\Recruitment\Interview\Questionnaire;

class QuestionnaireController extends Controller
{

    public function store(Request $request, $id)
    {
        $record = (new Questionnaire())->createQuestionnaire($id, $request);
        return response()->json(['message' => 'Interview questionnaire submitted'], 201);
    }

    public function show($id)
    {
        $response = Questionnaire::where('applicant_id', $id)->first();
        return response()->json($response, 200);
    }

    public function update(Request $request, $id)
    {
        $questionnaire = Questionnaire::where('applicant_id', $id)->firstOrFail();
        $questionnaire->update($request->all());
        return response()->json(['message' => 'Questionnaire details updated'], 200);
    }
}
