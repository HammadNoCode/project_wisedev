<?php

namespace App\Models\Staff\User;

use App\Models\Staff\Base;
use Carbon\Carbon;

class Branches extends Base
{
    protected $table = 'branches';

    protected $fillable = [
        'name',
    ];
}
