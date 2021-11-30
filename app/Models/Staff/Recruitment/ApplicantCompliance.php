<?php

namespace App\Models\Staff\Recruitment;

use App\Models\Staff\Base;
use App\Models\Staff\User\User;
use Carbon\Carbon;

/**
 * @property mixed $applicant_id
 * @property mixed $document_id
 * @property mixed $checked_by
 * @property mixed $test
 */

class ApplicantCompliance extends Base
{
    protected $table = 'applicant_compliance';


    protected $fillable = [
        'document_id',
        'applicant_id',
        'dbs_number',
        'issue_date',
        'renewal_date',
        'expiry_date',
        'expired',
        'filename',
        'url',
        'checked_by',
        'test',
    ];

    public static function env()
    {
        return (bool) User::whereId(session('staff_id'))->value('test');
    }

    public function compliance()
    {
        return $this->belongsTo('App\Models\Staff\Recruitment\Compliance', 'document_id');
    }

    public function createDocument($applicant, $id)
    {
        $this->applicant_id = $applicant->id;
        $this->document_id = $id;
        $this->checked_by = session('staff_id');
        $this->test = $this->env();
        $this->save();
        return $this;
    }

}
