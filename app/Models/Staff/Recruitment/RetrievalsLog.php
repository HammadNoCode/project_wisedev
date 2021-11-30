<?php

namespace App\Models\Staff\Recruitment;

use App\Models\Staff\Base;
use Carbon\Carbon;

class RetrievalsLog extends Base
{
    protected $table = 'application_retrievals';

    public function application()
    {
        return $this->belongsTo('App\Models\Staff\Recruitment\Application', 'applicant_id', 'id');
    }

    public function getUpdatedAtAttribute()
    {
        return Carbon::parse($this->attributes['updated_at'])->format('d M Y, H:i');
    }
}
