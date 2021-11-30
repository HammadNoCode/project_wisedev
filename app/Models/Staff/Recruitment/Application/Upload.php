<?php

namespace App\Models\Staff\Recruitment\Application;

use App\Models\Staff\Base;

class Upload extends Base
{
    protected $table = 'applicant_profile_picture';

    protected $fillable = [
        'applicant_id',
        'display_name',
        'filename',
        'url',
    ];
}
