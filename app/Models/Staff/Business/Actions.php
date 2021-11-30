<?php

namespace App\Models\Staff\Business;

use App\Models\Staff\Base;
use App\Models\Staff\User\User;

class Actions extends Base
{
    protected $table = 'client_actions';

    protected $fillable = [
        'client_id',
        'name',
        'assigned_to',
        'deadline',
        'completed_at',
        'test',
    ];

    public function getStaffNameAttribute()
    {
        return User::where('id', $this->attributes['assigned_to'])->value('name');
    }
}
