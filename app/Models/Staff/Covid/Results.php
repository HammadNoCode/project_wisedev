<?php

namespace App\Models\Staff\Covid;

use App\Models\Staff\Base;
use App\Models\Staff\Clinical\ClinicalStaff;
use App\Models\Staff\Recruitment\Application;
use Carbon\Carbon;

class Results extends Base
{
    use \Awobaz\Compoships\Compoships;

    protected $table = 'covid_results';

    protected $fillable = [
        'first_name',
        'archived'
    ];

    protected $casts = [
        'covid_result' => 'integer'
    ];

    protected $appends = [
        'contacted',
    ];

    public function application()
    {
        return $this->belongsTo('App\Models\Staff\Recruitment\Application', 'staff_id', 'id');
    }

    public function getContactedAttribute()
    {
        return ClinicalStaff::where('staff_id', $this->attributes['staff_id'])->value('contacted');
    }

    public function scopeArchived($query, $archived)
    {
        switch ($archived) {
            case ('no'):
                return $query->where('archived', 0);
            case ('yes'):
                return $query->where('archived', 1);
        }
    }

    public function scopeResultFilter($query, $filter)
    {
        switch ($filter) {
            case ('all'):
                return $query;
            default:
                return $query->where('covid_result', $filter);
        }
    }

    public function scopeSearch($query, $search)
    {
        return $query->where(function ($querys) use ($search) {
            $querys->orWhere("last_name", 'LIKE', "%{$search}%");
        });
    }

    public function getCreatedAtAttribute()
    {
        return Carbon::parse($this->attributes['created_at'])->format('d-m-Y g:ia');
    }
}
