<?php

namespace App\Models\Staff\Business;

use App\Models\Staff\Base;

class Client extends Base
{
    protected $table = 'clients';

    protected $fillable = [
        'name',
        'group_id',
        'email',
        'mobile',
        'address_1',
        'address_2',
        'city',
        'county',
        'postcode',
        'notes',
        'test',
    ];

    public function getGroupNameAttribute()
    {
        return Organisation::where('id', $this->attributes['group_id'])->value('name');
    }

    public function hours()
    {
        return $this->belongsTo('App\Models\Staff\Business\Client', 'client_id', 'id');
    }
}
