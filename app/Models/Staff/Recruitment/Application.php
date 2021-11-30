<?php

namespace App\Models\Staff\Recruitment;

use App\Models\Covid\Vaccination;
use App\Models\Staff\Events\Attendee;
use App\Models\Staff\Base;
use App\Models\Staff\Covid\Results;
use App\Models\Staff\Recruitment\Application\{Upload as Photo, Profile as AboutMe};
use App\Models\Staff\Recruitment\Interview\Questionnaire;
use App\Models\Staff\User\User as Staff;
use App\Models\Staff\User\User;
use Carbon\Carbon;

use function PHPSTORM_META\map;

class Application extends Base
{
    use \Awobaz\Compoships\Compoships;

    protected $table = 'applications';

    protected $fillable = [
        'position',
        'first_name',
        'last_name',
        'email',
        'address_line_1',
        'address_line_2',
        'city',
        'county',
        'postcode',
        'mobile',
        'landline',
        'national_insurance_number',
        'nurse_pin_number',
        'right_to_work',
        'qualifications',
        'most_recent_work',
        'relevant_skills',
        'referees',
        'drivers_licence',
        'in_good_health',
        'in_good_health_information',
        'offender',
        'offender_information',
        'declaration',
        'status',
        'sub_status',
        'source',
        'branch_id',
        'hired',
        'notes',
        'contacted',
        'phoned',
        'reminder_count',
        'test',
        'accept_date',
        'hire_date',
        'hours_pw',
        'favourite',
        'pulse',
        'covid_reminders',
        'resume_url'
    ];

    protected $dates = [
        'createed_at',
        'updated_at',
        'accept_date',
        'hire_date',
    ];

    public function application()
    {
        return $this->hasOne('App\Models\Staff\Compliance\DocumentMatrix', 'applicant_id', 'id');
    }

    public function completed_compliance()
    {
        return $this->hasMany('App\Models\Staff\Recruitment\ApplicantCompliance', 'applicant_id', 'id');
    }

    public function retrievals_log()
    {
        return $this->hasMany('App\Models\Staff\Recruitment\RetrievalsLog', 'applicant_id', 'id');
    }

    public function latest_test()
    {
        return $this->hasOne('App\Models\Staff\Covid\Results', ['staff_id', 'last_name'], ['id', 'last_name'])->latest();
    }

    public function latest_vaccination()
    {
        return $this->hasOne('App\Models\Staff\Vaccination\Proof', ['staff_id', 'last_name'], ['id', 'last_name'])->latest();
    }

    public function vaccination()
    {
        return $this->hasOne(Vaccination::class, 'staff_id', 'id');
    }

    public function training()
    {
        $training_ids = [7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21];
        return $this->hasMany(ApplicantCompliance::class, 'applicant_id', 'id')->whereIn('document_id', $training_ids);
    }

    public function getInterviewIdAttribute()
    {
        $applications = Application::get();
        $interview = Interview::where('applicant_id', $this->attributes['interview_id'])->value('status');
        switch ($interview) {
            case null:
                return "Not Contacted";
            case 0:
                return "Contacted";
            case 1:
                return "Planned";
            case 2:
                return "Completed";
            case 3:
                return "Successful";
            case 4:
                return "Rejected";
            case 5:
                return "No Show";
                break;
        }
    }

    public function getReferencesAttribute()
    {
        $references = Reference::where('applicant_id', $this->attributes['references'])->pluck('status')->toArray();
        if ($references != null) {
            foreach ($references as $key => $status) {
                switch ($status) {
                    case 1:
                        $references[$key] = "Pending";
                        break;
                    case 2:
                        $references[$key] = "Received";
                        break;
                    case 0:
                    default:
                        $references[$key] = "Not Contacted";
                        break;
                }
            }
            return implode(' / ', array_unique($references));
        } else {
            return "Not Requested";
        }
    }

    public function getCompletedAtAttribute()
    {
        if (!$this->attributes['completed_at']) {
            return 'Awaiting response';
        }
        return Carbon::parse($this->attributes['completed_at'])->format('d/m/Y H:i');
    }

    public function completed_two_reference()
    {
        return $this->hasOne(ApplicantCompliance::class, 'applicant_id', 'id')->where('document_id', 1);
    }

    public function completed_induction_attendance()
    {
        return $this->hasOne(ApplicantCompliance::class, 'applicant_id', 'id')->where('document_id', 2);
    }

    public function completed_mandatory_training()
    {
        return $this->hasOne(ApplicantCompliance::class, 'applicant_id', 'id')->where('document_id', 3);
    }

    public function completed_dbs_check()
    {
        return $this->hasOne(ApplicantCompliance::class, 'applicant_id', 'id')->where('document_id', 4);
    }

    public function dbs_details()
    {
        return $this->hasOne(DocumentDetails::class, 'applicant_id', 'id')->where('document_id', 4);
    }

    public function completed_nurse_pin()
    {
        return $this->hasOne(ApplicantCompliance::class, 'applicant_id', 'id')->where('document_id', 5);
    }

    public function completed_right_to_work()
    {
        return $this->hasOne(ApplicantCompliance::class, 'applicant_id', 'id')->where('document_id', 6);
    }

    public function completed_proof_of_address()
    {
        return $this->hasOne(ApplicantCompliance::class, 'applicant_id', 'id')->where('document_id', 28);
    }

    public function total_compliance_items()
    {
        return $this->hasMany(ApplicantCompliance::class, 'applicant_id', 'id');
    }

    public function completed_document_compliance()
    {
        return $this->hasOne(ApplicantCompliance::class, 'applicant_id', 'id');
    }

    public function profile_picture()
    {
        return $this->hasOne(Photo::class, 'applicant_id', 'id');
    }

    public function about_me()
    {
        return $this->hasOne(AboutMe::class, 'applicant_id', 'id');
    }

    public function interview_notes()
    {
        return $this->hasOne(Questionnaire::class, 'applicant_id', 'id');
    }

    public function scopeTest($query)
    {
        $test = User::where('id', session('staff_id'))->pluck('test');
        return $query->where('test', $test);
    }

    public function scopeStatus($query, $status)
    {
        switch ($status) {
            case ('Application'):
                return $query->where('status', 0);
            case ('Screening'):
                return $query->where('status', 1);
                    //->whereNull('hired');
            case ('Interview'):
                return $query->where('status', 2);
            case ('Offered'):
                return $query->where('status', 3);
            case ('Onboarding'):
                return $query->where('status', 4);
            case ('Active'):
                return $query->where('status', 5);
            case ('Leaver'):
                return $query->where('status', 6);
            case ('Pipeline'):
                return $query->where('status', 7);
            case ('incomplete'):
                return $query->where('declaration', null);
            case ('contacted'):
                return $query->where('contacted', 1);
            case ('completed'):
                return $query->whereNotNull('declaration')->where('contacted', 0);
            case ('live'):
                return $query->where('hired', 1);
            default:
                return $query;
        }
    }

    public function scopeStatusSub($query, $statusSub)
    {
        switch ($statusSub) {
            case ('1'):
                return $query->where('sub_status', 1);
            case ('10'):
                return $query->where('sub_status', 10);
            case ('11'):
                return $query->where('sub_status', 11);
            case ('12'):
                return $query->where('sub_status', 12);
            case ('13'):
                return $query->where('sub_status', 13);
            case ('14'):
                return $query->where('sub_status', 14);
            case ('15'):
                return $query->where('sub_status', 15);
            case ('16'):
                return $query->where('sub_status', 16);
            case ('17'):
                return $query->where('sub_status', 17);
            case ('18'):
                return $query->where('sub_status', 18);
            case ('19'):
                return $query->where('sub_status', 19);
            case ('20'):
                return $query->where('sub_status', 20);
            case ('21'):
                return $query->where('sub_status', 21);
            case ('22'):
                return $query->where('sub_status', 22);
            case ('23'):
                return $query->where('sub_status', 23);
            case ('24'):
                return $query->where('sub_status', 24);
            case ('25'):
                return $query->where('sub_status', 25);
            case ('26'):
                return $query->where('sub_status', 26);
            case ('27'):
                return $query->where('sub_status', 27);
            case ('28'):
                return $query->where('sub_status', 28);
            case ('29'):
                return $query->where('sub_status', 29);
            case ('30'):
                return $query->where('sub_status', 30);
            case ('30'):
                return $query->where('sub_status', 30);
            case ('31'):
                return $query->where('sub_status', 31);
            case ('32'):
                return $query->where('sub_status', 32);
            case ('33'):
                return $query->where('sub_status', 33);
            case ('34'):
                return $query->where('sub_status', 34);
            case ('35'):
                return $query->where('sub_status', 35);
            case ('36'):
                return $query->where('sub_status', 36);
            case ('37'):
                return $query->where('sub_status', 37);
            case ('38'):
                return $query->where('sub_status', 38);
            case ('39'):
                return $query->where('sub_status', 39);
            case ('40'):
                return $query->where('sub_status', 40);
            case ('41'):
                return $query->where('sub_status', 41);
            case ('42'):
                return $query->where('sub_status', 42);
            case ('43'):
                return $query->where('sub_status', 43);
            case ('44'):
                return $query->where('sub_status', 44);
            case ('45'):
                return $query->where('sub_status', 45);
            case ('46'):
                return $query->where('sub_status', 46);
            case ('47'):
                return $query->where('sub_status', 47);
            case ('48'):
                return $query->where('sub_status', 48);
            case ('49'):
                return $query->where('sub_status', 49);
            case ('50'):
                return $query->where('sub_status', 50);
            case ('51'):
                return $query->where('sub_status', 51);
            case ('52'):
                return $query->where('sub_status', 52);
            case ('53'):
                return $query->where('sub_status', 53);
            case ('54'):
                return $query->where('sub_status', 54);
            case ('55'):
                return $query->where('sub_status', 55);
            case ('56'):
                return $query->where('sub_status', 56);
            case ('57'):
                return $query->where('sub_status', 57);
            case ('58'):
                return $query->where('sub_status', 58);
            case ('59'):
                return $query->where('sub_status', 59);

            default:
                return $query;
        }
    }

    public function scopeBranch($query, $branch)
    {
        switch ($branch) {
            case ('all'):
                return $query;
            case ('Lancashire'):
                return $query->where('branch_id', 1);
            case ('Warrington'):
                return $query->where('branch_id', 2);
            case ('Crewe'):
                return $query->where('branch_id', 3);
            case ('Liverpool'):
                return $query->where('branch_id', 4);
            case ('Manchester'):
                return $query->where('branch_id', 5);
            case ('Leeds'):
                return $query->where('branch_id', 6);
            case ('Shrewsbury'):
                return $query->where('branch_id', 7);
            case ('Chester'):
                return $query->where('branch_id', 8);
            case ('Permanent'):
                return $query->where('branch_id', 9);
            case ('Complex Care'):
                return $query->where('branch_id', 10);
            case ('Head Office'):
                return $query->where('branch_id', 11);
            default:
                return $query->where('branch_id', $branch);
        }
    }

    public function scopePosition($query, $position)
    {
        switch ($position) {
            case ('all'):
                return $query;
            default:
                return $query->where('position', $position);
                break;
        }
    }

    public function scopeSort($query, $sort)
    {
        switch ($sort) {
            case 'newest':
                return $query->orderBy('created_at', 'desc');
            case 'oldest':
                return $query->orderBy('created_at', 'asc');
        }
    }

    public function scopeSearch($query, $search)
    {
        return $query->where(function ($querys) use ($search) {
            $querys->orWhere("position", 'LIKE', "%{$search}%");
            $querys->orWhere("first_name", 'LIKE', "%{$search}%");
            $querys->orWhere("last_name", 'LIKE', "%{$search}%");
            $querys->orWhere("landline", 'LIKE', "%{$search}%");
            $querys->orWhere("mobile", 'LIKE', "%{$search}%");
            $querys->orWhere("email", 'LIKE', "%{$search}%");
            $querys->orWhere("postcode", 'LIKE', "%{$search}%");
            $querys->orWhere("address_line_1", 'LIKE', "%{$search}%");
            $querys->orWhere("address_line_2", 'LIKE', "%{$search}%");
            $querys->orWhere("postcode", 'LIKE', "%{$search}%");
            $querys->orWhere("county", 'LIKE', "%{$search}%");
        });
    }

    public function scopeDriver($query, $driver)
    {
        switch ($driver) {
            case ('yes'):
                return $query->where('drivers_licence', 'Yes')->orWhere('drivers_licence', 'yes');
            case ('no'):
                return $query->where('drivers_licence', 'No')->orWhere('drivers_licence', 'no');
            default:
                return $query;
        }
    }

    public function scopeScore($query, $score)
    {
        switch ($score) {
            case ('0-4'):
                return $query->whereHas('interview_notes', function ($query) {
                    $query->whereBetween('overall_score', [0, 4]);
                });
            case ('5-7'):
                return $query->whereHas('interview_notes', function ($query) {
                    $query->whereBetween('overall_score', [5, 7]);
                });
            case ('8-10'):
                return $query->whereHas('interview_notes', function ($query) {
                    $query->whereBetween('overall_score', [8, 10]);
                });
            case ('all'):
                return $query;
        }
    }

    public function scopeShift($query, $shift)
    {
        switch ($shift) {
            case ('days'):
                return $query->whereHas('interview_notes', function ($query) {
                    $query->where('shift_type', 0);
                });
            case ('nights'):
                return $query->whereHas('interview_notes', function ($query) {
                    $query->where('shift_type', 1);
                });
            case ('both'):
                return $query->whereHas('interview_notes', function ($query) {
                    $query->where('shift_type', 2);
                });
            default:
                return $query;
        }
    }

    public function scopeFavourite($query, $favourite)
    {
        switch ($favourite) {
            case ('yes'):
                return $query->where('favourite', 1);
            case ('no'):
                return $query->where('favourite', 0);
            default:
                return $query;
        }
    }

    public function scopeHours($query, $hours)
    {
        switch ($hours) {
            case ('0-24'):
                return $query->whereBetween('hours_pw', [0, 24]);
            case ('25-48'):
                return $query->whereBetween('hours_pw', [25, 48]);
            case ('49'):
                return $query->where('hours_pw', '>', 48);
            default:
                return $query;
        }
    }

    public function scopeSource($query, $source)
    {
        switch ($source) {
            case ('All'):
                return $query;
            default:
                return $query->where('source', $source);
        }
    }
}
