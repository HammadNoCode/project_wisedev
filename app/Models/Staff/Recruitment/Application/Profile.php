<?php

namespace App\Models\Staff\Recruitment\Application;

use App\Models\Staff\Base;

class Profile extends Base
{
    protected $table = 'applicant_profile';

    protected $fillable = [
        'applicant_id',
        'about_me',
    ];

    public function createProfile($id, $request)
    {
        $this->applicant_id = $id;
        $this->about_me = $request->about_me;
        $this->save();
        return $this;
    }
}
