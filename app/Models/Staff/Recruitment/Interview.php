<?php

namespace App\Models\Staff\Recruitment;

use Illuminate\Support\{Str};
use App\Models\Staff\User\User;
use App\Models\Staff\Base;
use Carbon\Carbon;

/**
 * @property mixed $status
 * @property mixed $email
 * @property mixed $applicant_id
 * @property mixed $test
 * @property mixed $email
 * @property mixed $token
 */

class Interview extends Base
{
    protected $table = 'interviews';

    protected $fillable = [
        'applicant_id',
        'email',
        'date',
        'time',
        'staff_id',
        'status',
        'note',
        'test'
    ];

    protected $appends = ['branch_id'];

    public static function env()
    {
        return (bool) User::whereId(session('staff_id'))->value('test');
    }

    public function application()
    {
        return $this->belongsTo('App\Models\Staff\Recruitment\Application', 'applicant_id');
    }

    public function getBranchIdAttribute()
    {
        return Application::where('id', $this->attributes['applicant_id'])->value('branch_id');
    }

    public function createInvite($applicant, $request)
    {
        $this->status = 0;
        $this->email = $applicant->email;
        $this->applicant_id = $applicant->id;
        $this->test = $this->env();
        $this->save();
        return $this;
    }

    public function sendReminder($reminder)
    {
        $this->email = $reminder->email;
        $this->token = $reminder->token;
        $this->applicant_id = $reminder->id;
        $this->save();
        return $this;
    }

    public function scopeByStaffId($query, $id)
    {
        return $query->where('staff_id', $id);
    }

    public function scopeCompleted($query): int
    {
        return $query->whereStatus(1)->count();
    }

    public function getApplicationStatusAttribute()
    {
        return Application::where('id', $this->attributes['application_status'])->value('status');
    }

    public function getPositionAttribute()
    {
        return Application::where('id', $this->attributes['position'])->value('position');
    }

    public function getFirstNameAttribute()
    {
        $first_name = Application::where('id', $this->attributes['first_name'])->value('first_name');
        return $first_name;
    }

    public function getLastNameAttribute()
    {
        return Application::where('id', $this->attributes['last_name'])->value('last_name');
    }

    public function getStaffNameAttribute()
    {
        return User::where('id', $this->attributes['staff_name'])->value('name');
    }

    public function getScheduledDateAttribute()
    {
        if (!$this->attributes['scheduled_date']) {
            return 'Awaiting response';
        }
        return Carbon::parse($this->attributes['scheduled_date'])->format('d/m/Y');
    }

    public function getScheduledTimeAttribute()
    {
        if (!$this->attributes['scheduled_time']) {
            return 'Awaiting response';
        }
        return Carbon::parse($this->attributes['scheduled_time'])->format('H:i');
    }

    public function getResponseAttribute()
    {
        switch ((int) $this->attributes['response']) {
            case 1:
                return 'Planned';
            case 2:
                return 'Completed';
            case 3:
                return 'Successful';
            case 4:
                return 'Rejected';
            case 5:
                return 'No Show';
            case 0:
            default:
                return 'Pending';
        }
    }

    public function scopeBranch($query, $branch)
    {
        switch ($branch) {
            case "all":
                return $query;
            default:
                return $query->whereHas('application', function ($q) use ($branch) {
                    return $q->where('branch_id', $branch);
                });
        }
    }

    public function scopeStatus($query, $status)
    {
        switch ($status) {
            case "all":
                return $query;
            default:
                return $query->where('status', $status);
        }
    }

    public function scopeInterviewer($query, $interviewer)
    {
        switch ($interviewer) {
            case 'all':
                return $query;
            default:
                return $query->where('staff_id', $interviewer);
        }
    }
}
