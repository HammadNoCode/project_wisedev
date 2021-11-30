<?php

namespace App\Models\Staff\Business;

use App\Models\Staff\Base;
use App\Models\Staff\User\User;
use Carbon\Carbon;

class Notes extends Base
{
    protected $table = 'client_notes';

    protected $fillable = [
        'client_id',
        'staff_id',
        'notes',
        'deleted',
        'test',
    ];

    public function getStaffNameAttribute()
    {
        return User::where('id', $this->attributes['staff_id'])->value('name');
    }

    public function getCreatedAtAttribute()
    {
        return Carbon::parse($this->attributes['created_at'])->format('d/m/Y H:i');
    }
}
