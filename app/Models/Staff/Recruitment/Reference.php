<?php

namespace App\Models\Staff\Recruitment;

use Illuminate\Support\{Str};
use App\Models\Staff\Base;
use App\Models\Staff\User\User;
use Carbon\Carbon;

/**
 * @property mixed $name
 * @property mixed $mobile
 * @property mixed $email
 * @property mixed $type
 * @property mixed $token
 * @property mixed $applicant_id
 * @property mixed $test
 */

class Reference extends Base
{
    protected $table = 'references';

    protected $fillable = [
        'declaration',
        'mobile',
        'email',
        'status',
        'reminder_count',
        'occupation',
        'safeguard_check',
        'employed_to',
        'employed_from',
        'known_since',
        'related',
        'capacity',
        'note',
        'manually',
        'staff_note',
        'test',
    ];

    public static function env()
    {
        return (bool) User::whereId(session('staff_id'))->value('test');
    }

    public function createInvite($request)
    {
        $this->name = $request->data['name'];
        $this->mobile = $request->data['mobile'];
        $this->email = $request->data['email'];
        $this->type = $request->data['type'];
        $this->token = Str::random(12);
        $this->applicant_id = $request->id;
        $this->test = $this->env();
        $this->save();
        return $this;
    }

    public function sendReminder($referees)
    {
        $this->email = $referees->email;
        $this->token = $referees->token;
        $this->applicant_id = $referees->id;
        $this->save();
        return $this;
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
        return Application::where('id', $this->attributes['first_name'])->value('first_name');
    }

    public function getLastNameAttribute()
    {
        return Application::where('id', $this->attributes['last_name'])->value('last_name');
    }

    public function getRefereeNameAttribute()
    {
        return Reference::where('name', $this->attributes['name'])->value('name');
    }

    public function getScheduledTimeAttribute()
    {
        if (!$this->attributes['completed_at']) {
            return 'Awaiting response';
        }
        return Carbon::parse($this->attributes['completed_at'])->format('H:i');
    }

    public function getCompletedAtAttribute()
    {
        if (!$this->attributes['completed_at']) {
            return 'Awaiting response';
        }
        return Carbon::parse($this->attributes['completed_at'])->format('d/m/Y', 'H:i');
    }

    public function getCreatedAtAttribute()
    {
        if (!$this->attributes['created_at']) {
            return 'Awaiting response';
        }
        return Carbon::parse($this->attributes['created_at'])->format('d/m/Y', 'H:i');
    }

    public function getRespondedAttribute()
    {
        switch ((int) $this->attributes['responded']) {
            case 1:
                return 'Awaiting';
            case 2:
                return 'Completed';
            case 3:
                return 'Declined';
            case 0:
            default:
                return 'Not-requested';
        }
    }

    public function scopeStatus($query, $status)
    {
        switch ($status) {
            case ('not-requested'):
                return $query->where('status', null);
            case ('awaiting'):
                return $query->where('status', 1);
            case ('completed'):
                return $query->where('status', 2);
            default:
                return $query;
        }
    }

    public function scopeSort($query, $sort)
    {
        switch ($sort) {
            case 'newest':
                $query->orderBy('updated_at', 'desc');
            case 'oldest':
                $query->orderBy('updated_at', 'asc');
        }
    }

    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->orWhere('name', 'LIKE', "%{$search}%");
            $q->orWhere('email', 'LIKE', "%{$search}%");
        });
    }
}
