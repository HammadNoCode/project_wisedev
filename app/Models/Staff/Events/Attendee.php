<?php

namespace App\Models\Staff\Events;

use App\Models\Staff\User\User as Staff;
use App\Models\Staff\Recruitment\Application;
use App\Models\Staff\Events\Event;
use Illuminate\Support\{Str};
use App\Models\Staff\Base;
use Carbon\Carbon;

/**
 * @property mixed $attendee_id
 * @property mixed $event_id
 * @property mixed $token
 */

class Attendee extends Base
{
    protected $table = 'event_attendees';

    protected $fillable = [
        'event_id',
        'attendee_id',
        'attendee_type',
        'attendance',
        'status',
        'token'
    ];

    public function event()
    {
        return $this->belongsTo('App\Models\Staff\Events\Event', 'event_id', 'id');
    }

    public function application()
    {
        return $this->hasOne('App\Models\Staff\Recruitment\Application', 'id', 'attendee_id');
    }

    public function staff()
    {
        return $this->hasOne('App\Models\Staff\User\User', 'id', 'attendee_id');
    }

    public function createBookingRequest($request, $id)
    {
        $this->attendee_id = $request->attendee_id;
        $this->attendee_type = $request->attendee_type;
        $this->event_id = $id;
        $this->token = Str::random(12);
        $this->save();
        return $this;
    }

    public function getAttendeeTypeAttribute()
    {
        switch ((int) $this->attributes['attendee_type']) {
            case 1:
                return 'Applicant';
            case 2:
                return 'Staff';
            case 0:
            default:
                return 'n/a';
        }
    }
}
