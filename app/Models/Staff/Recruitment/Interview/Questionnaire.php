<?php

namespace App\Models\Staff\Recruitment\Interview;

use App\Models\Staff\Base;

class Questionnaire extends Base
{
    protected $table = 'interview_questions';

    protected $fillable = [
        'applicant_id',
        'experience',
        'strengths',
        'exceed_example',
        'skills',
        'scenario_one',
        'scenario_two',
        'outcome',
        'shift_type',
        'shifts',
        'hobbies',
        'overall_score',
        'test'
    ];

    public function createQuestionnaire($id, $request)
    {
        $this->applicant_id = $id;
        $this->experience = $request->experience;
        $this->strengths = $request->strengths;
        $this->exceed_example = $request->exceed_example;
        $this->skills = $request->skills;
        $this->scenario_one = $request->scenario_one;
        $this->scenario_two = $request->scenario_two;
        $this->outcome = $request->outcome;
        $this->shift_type = $request->shift_type;
        $this->shifts = $request->shifts;
        $this->hobbies = $request->hobbies;
        $this->overall_score = $request->overall_score;
        $this->save();
        return $this;
    }
}
