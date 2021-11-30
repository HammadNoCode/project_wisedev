<?php

namespace App\Models\Staff\User;

use App\Models\Staff\Base;
use App\Models\Staff\User\User;

class Department extends Base
{
    protected $table = 'users_departments';

    public function staff()
    {
        return $this->hasMany(User::class, 'department', 'id')->where('deleted', 0);
    }
}
