<?php

namespace App\Models\Staff\Compliance;

use App\Models\Staff\Base;
use App\Models\Staff\Recruitment\{Application, Compliance};
use Carbon\Carbon;

class Tracker extends Base
{
    protected $table = 'applicant_compliance';

    protected $appends = ['type'];

    public function document()
    {
        return $this->belongsTo('App\Models\Staff\Recruitment\Compliance', 'document_id');
    }

    public function getTypeAttribute()
    {
        return Compliance::where('id', $this->attributes['document_id'])->value('type');
    }

    public function getFirstNameAttribute()
    {
        return Application::where('id', $this->attributes['first_name'])->value('first_name');
    }

    public function getLastNameAttribute()
    {
        return Application::where('id', $this->attributes['last_name'])->value('last_name');
    }

    public function getDocumentNameAttribute()
    {
        return Compliance::where('id', $this->attributes['document_name'])->value('name');
    }

    public function getRenewalDateAttribute()
    {
        return Carbon::parse($this->attributes['renewal_date'])->format('d M, Y');
    }
}
