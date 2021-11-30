<?php

namespace App\Models\Staff\Business;

use App\Models\Staff\Base;
use App\Models\Staff\User\User;
use Carbon\Carbon;

class Hours extends Base
{
    protected $table = 'client_hours';

    protected $fillable = [
        'client_id',
        'requested_hours',
        'provided_hours',
        'test',
    ];

    public function getCreatedAtAttribute()
    {
        return Carbon::parse($this->attributes['created_at'])->format('d/m/Y');
    }
}
