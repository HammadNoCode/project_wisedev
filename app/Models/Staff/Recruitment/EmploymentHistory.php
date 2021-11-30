<?php

namespace App\Models\Staff\Recruitment;

use App\Models\Staff\Base;
use Carbon\Carbon;

class EmploymentHistory extends Base
{
    protected $table = 'employment_history';

    protected $fillable = [
        'applicant_id',
        'name',
        'role',
        'employed_from',
        'employed_to',
    ];
}
