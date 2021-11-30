<?php

namespace App\Models\Staff\Business;

use App\Models\Staff\Base;
use App\Models\Staff\User\User;

/**
 * @property mixed $client_id
 * @property mixed $test
 */

class Contacts extends Base
{
    protected $table = 'client_contacts';

    protected $fillable = [
        'client_id',
        'name',
        'type',
        'phone',
        'email',
        'test',
    ];
}
