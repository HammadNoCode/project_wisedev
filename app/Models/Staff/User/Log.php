<?php

namespace App\Models\Staff\User;

use App\Models\Staff\Base;

/**
 * @property mixed $user_id
 * @property mixed $message
 */

class Log extends Base
{
    protected $table = 'users_logs';

    public function createLog($user_id, $message)
    {
        $this->user_id = $user_id;
        $this->message = $message;
        $this->save();
        return $this;
    }
}
