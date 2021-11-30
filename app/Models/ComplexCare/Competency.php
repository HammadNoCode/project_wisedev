<?php

namespace App\Models\ComplexCare;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Competency extends Model
{
    use HasFactory;

    protected $table = 'complex_care_competencies';

    protected $fillable = [
        'nurse_name',
        'staff_name',
        'displayname',
        'filename',
        'url',
    ];

    public function createCompetencyRecord($request, $displayname, $filename, $path)
    {
        $this->nurse_name = $request->nurse;
        $this->staff_name = $request->staff;
        $this->displayname = $displayname;
        $this->filename = $filename;
        $this->url = 'https://cavalry-staff-competence.s3.eu-west-2.amazonaws.com/' . $path;
        $this->save();
        return $this;
    }
}
