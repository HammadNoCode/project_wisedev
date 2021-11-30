<?php

namespace App\Models\Staff\Business;

use App\Models\Staff\Base;
use Carbon\Carbon;

class Communications extends Base
{
    protected $table = 'client_conversations';

    protected $fillable = [
        'client_id',
        'contact_id',
        'date',
        'time',
        'notes',
        'test',
    ];

    public function getContactNameAttribute()
    {
        return Contacts::where('id', $this->attributes['contact_name'])->value('name');
    }
}
