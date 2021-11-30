<?php

namespace App\Models\Staff\Business;

use App\Models\Staff\Base;

class Organisation extends Base
{
    protected $table = 'organisations';

    protected $fillable = [
        'name',
        'email',
        'mobile',
        'telephone',
        'address_1',
        'address_2',
        'city',
        'county',
        'postcode',
        'test',
    ];

    public function clients()
    {
        return $this->hasMany('App\Models\Staff\Business\Client', 'group_id', 'id');
    }
}
