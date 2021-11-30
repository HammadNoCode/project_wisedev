<?php

namespace App\Models\Staff\Clinical;

use App\Models\Staff\Base;
use App\Models\Staff\Events\{Attendee, Event};
use App\Models\Staff\Recruitment\Application;
use App\Models\Staff\User\User;
use Carbon\Carbon;

class ClinicalStaff extends Base
{
    protected $table = 'clinical_staff';

    protected $casts = [
        'active' => 'boolean',
    ];

    protected $fillable = [
        'staff_id',
        'hired_by',
        'covid_reminders',
        'vaccination_invite',
        'active',
    ];

    public function getStaffNameAttribute()
    {
        return User::where('id', $this->attributes['staff_name'])->value('name');
    }

    public function application()
    {
        return $this->belongsTo('App\Models\Staff\Recruitment\Application', 'staff_id');
    }

    public function latest_test()
    {
        return $this->hasOne('App\Models\Staff\Covid\Results', 'staff_id', 'staff_id')->latest();
    }

    public function vaccination()
    {
        return $this->hasOne('App\Models\Staff\Vaccination\Proof', 'staff_id', 'staff_id')->latest();
    }

    public function scopeBranch($query, $branch)
    {
        if ($branch == 0) {
            return $query;
        } else {
            $applicantFilter = Application::where('hired', 1)->where('branch_id', $branch)->pluck('id');
            return $query->whereIn('staff_id', $applicantFilter);
        }
    }

    public function scopeActive($query, $active)
    {
        return $query->where('active', $active);
    }

    public function scopeSort($query, $sort)
    {
        switch ($sort) {
            case 'newest':
                return $query->orderBy('created_at', 'desc');
            default:
                return $query->orderBy('created_at', 'asc');
        }
    }

    public function scopeSearch($query, $search) 
    {
        return $query->whereHas('application', function ($query) use ($search) {
            $query->where("first_name", 'LIKE', "{$search}%");
            $query->orWhere("last_name", 'LIKE', "{$search}%");
        });
    }
}
