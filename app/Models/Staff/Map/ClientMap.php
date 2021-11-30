<?php

namespace App\Models\Staff\Map;

use App\Models\Staff\Recruitment\Application;
use App\Models\Staff\Base;
use App\Models\Staff\Business\Hours;
use Carbon\Carbon;

class ClientMap extends Base
{
    protected $table = 'client_map';

    public function client()
    {
        return $this->belongsTo('App\Models\Staff\Business\Client', 'client_id', 'id');
    }
}
