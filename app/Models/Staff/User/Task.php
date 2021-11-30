<?php

namespace App\Models\Staff\User;

use App\Models\Staff\User\{Branches, User as Staff};
use App\Models\Staff\Base;

/**
 * @property mixed $repeat
 */

class Task extends Base
{
    protected $table = 'users_tasks';

    protected $fillable = ['user_id', 'description', 'status', 'repeat', 'staff_assigned'];

    protected $dates = ['scheduled_at'];

    protected $appends = ['repeat_occurance'];

    public function getRepeatOccuranceAttribute()
    {
        switch ((int) $this->repeat) {
            case 1:
                return 'Daily';
            break;
            case 2:
                return 'Weekly';
            break;
            case 3:
                return 'Monthly';
            break;
            default:
                return null;
            break;
        }
    }

    public function getUserIdAttribute()
    {
        return Staff::where('id', $this->attributes['user_id'])->value('name');
    }
}
