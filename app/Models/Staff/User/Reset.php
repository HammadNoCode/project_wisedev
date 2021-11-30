<?php

namespace App\Models\Staff\User;

use Illuminate\Support\Str;
use App\Models\Staff\Base;

/**
 * @property mixed $email
 * @property mixed $token
 */

class Reset extends Base
{
    protected $table = 'users_password_resets';

    public function createReset($user)
    {
        $this->email = $user->email;
        $this->token = Str::random(64);
        $this->save();
        return $this;
    }
}
