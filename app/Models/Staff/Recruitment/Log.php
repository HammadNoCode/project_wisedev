<?php

namespace App\Models\Staff\Recruitment;

use App\Models\Staff\Base;
use App\Models\Staff\User\User as Staff;
use Carbon\Carbon;

/**
 * @property mixed $applicant_id
 * @property mixed $staff_id
 * @property mixed $message
 */

class Log extends Base
{
    protected $table = 'logs';

    protected $fillable = ['message'];

    public $appends = ['interview_notes'];

    public function getInterviewNotesAttribute()
    {
        return Interview::where('id')->get();
    }

    public function createLog($applicant_id, $staff_id, $message)
    {
        $this->applicant_id = $applicant_id;
        $this->staff_id = $staff_id;
        $this->message = $message;
        $this->save();
        return $this;
    }

    public function getStaffNameAttribute()
    {
        return Staff::where('id', $this->attributes['staff_name'])->value('name');
    }

    public function getApplicantNameAttribute()
    {
        $applicant = Application::where('id', $this->attributes['applicant_name'])
            ->select('first_name', 'last_name')
            ->first();
        return "{$applicant->first_name} {$applicant->last_name}";
    }

    public function getActionDateAttribute()
    {
        return Carbon::parse($this->attributes['action_date'])->format('d/m/Y H:i');
    }
}
