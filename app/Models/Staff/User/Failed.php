<?php

namespace App\Models\Staff\User;

use App\Models\Staff\Base;

/**
 * @property mixed $email
 */

class Failed extends Base
{
    protected $table = 'users_failed_logins';

    public function createFailure($email)
    {
        $this->email = $email;
        $this->save();
        return $this;
    }
}
