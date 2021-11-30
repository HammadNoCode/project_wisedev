<?php

namespace App\Models\Staff\Recruitment;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

/**
 * @property mixed $dbs_number
 */

class DocumentDetails extends Model
{
    protected $table = 'compliance_document_details';

    protected $fillable = [
        'document_id',
        'applicant_id',
        'dbs_number',
        'issue_date',
        'date_checked',
        'online',
        'passport_number',
        'passport_expiry',
        'visa_number',
        'visa_type',
        'hours',
        'visa_expiry',
    ];

    public function createDetails($applicant, $id, $request)
    {
        $this->document_id = $id;
        $this->applicant_id = $applicant->id;
        $this->dbs_number = $request->dbs_number;
        $this->issue_date = $request->issue_date;
        $this->date_checked = $request->date_checked;
        $this->online = $request->online;
        $this->passport_number = $request->passport_number;
        $this->passport_expiry = $request->passport_expiry;
        $this->visa_number = $request->visa_number;
        $this->visa_type = $request->visa_type;
        $this->hours = $request->hours;
        $this->visa_expiry = $request->visa_expiry;
        $this->save();
        return $this;
    }
}
