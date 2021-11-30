<?php

namespace App\Models\Staff\Vaccination;

use App\Models\Staff\Base;
use App\Models\Staff\Recruitment\Application;

class Proof extends Base
{
    use \Awobaz\Compoships\Compoships;

    protected $table = 'vaccination_proof';

    public function getFirstNameAttribute()
    {
        return Application::where('id', $this->attributes['first_name'])->where('last_name', $this->attributes['last_name'])->value('first_name');
    }
}
