<?php

namespace App\Models\Staff\Compliance;

use App\Models\Staff\Base;
use App\Models\Staff\Recruitment\{Application, Compliance};
use Carbon\Carbon;

class DocumentMatrix extends Base
{
    public function application()
    {
        return $this->belongsTo('App\Models\Staff\Recruitment\Application');
    }

    public function getFirstNameAttribute()
    {
        return Application::where('id', $this->attributes['first_name'])->value('first_name');
    }

    public function getLastNameAttribute()
    {
        return Application::where('id', $this->attributes['last_name'])->value('last_name');
    }
}
