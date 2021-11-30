<?php

namespace App\Models\Pulse;

use App\Models\Staff\Base;

class Staff extends Base
{
    use \Awobaz\Compoships\Compoships;

    protected $table = 'clinical_staff_pulse';

    protected $fillable = [
        'deleted',
        'vaccination_invite',
        'duplicate',
    ];

    public function latest_test()
    {
        return $this->hasOne('App\Models\Staff\Covid\Results', ['staff_id', 'last_name'], ['unique_id', 'last_name'])->latest();
    }

    public function latest_vaccination()
    {
        return $this->hasOne('App\Models\Staff\Vaccination\Proof', ['staff_id', 'last_name'], ['unique_id', 'last_name'])->latest();
    }

    public function application()
    {
        return $this->belongsTo('App\Models\Staff\Recruitment\Application', 'email', 'email');
    }
}
