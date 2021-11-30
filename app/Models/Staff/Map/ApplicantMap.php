<?php

namespace App\Models\Staff\Map;

use App\Models\Staff\Recruitment\Application;
use App\Models\Staff\Base;
use Carbon\Carbon;

class ApplicantMap extends Base
{
    protected $table = 'applicant_map';

    // public $appends = ['position', 'first_name', 'last_name', 'postcode', 'address_line_1', 'address_line_2', 'city', 'mobile'];

    public function application()
    {
        return $this->belongsTo('App\Models\Staff\Recruitment\Application', 'applicant_id', 'id');
    }

    public function getPositionAttribute()
    {
        return Application::where('id', $this->attributes['applicant_id'])->value('position');
    }

    public function getFirstNameAttribute()
    {
        return Application::where('id', $this->attributes['applicant_id'])->value('first_name');
    }

    public function getLastNameAttribute()
    {
        return Application::where('id', $this->attributes['applicant_id'])->value('last_name');
    }

    public function getPostCodeAttribute()
    {
        return Application::where('id', $this->attributes['applicant_id'])->value('postcode');
    }

    public function getAddressLine1Attribute()
    {
        return Application::where('id', $this->attributes['applicant_id'])->value('address_line_1');
    }

    public function getAddressLine2Attribute()
    {
        return Application::where('id', $this->attributes['applicant_id'])->value('address_line_2');
    }

    public function getCityAttribute()
    {
        return Application::where('id', $this->attributes['applicant_id'])->value('city');
    }
}
