<?php

namespace App\Models\Staff\Events;

use App\Models\Staff\Events\Attendee;
use App\Models\Staff\Recruitment\Application;
use App\Models\Staff\User\User as Staff;
use App\Models\Staff\Base;
use Carbon\Carbon;

class Event extends Base
{
    protected $table = 'events';

    protected $fillable = [
        'type',
        'agenda',
        'attendee_type',
        'description',
        'time',
        'date',
        'location',
        'address',
        'postcode'
    ];

    public function attendees()
    {
        return $this->hasMany('App\Models\Staff\Events\Attendee');
    }

    public function getEventNameAttribute()
    {
        switch ((int) $this->attributes['event_name']) {
            case 1:
                return 'Induction';
            case 2:
                return 'Training';
        }
    }

    public function getScheduledDateAttribute()
    {
        return Carbon::parse($this->attributes['date'])->format('d/m/Y');
    }

    public function getScheduledTimeAttribute()
    {
        return Carbon::parse($this->attributes['time'])->format('H:i');
    }
}
