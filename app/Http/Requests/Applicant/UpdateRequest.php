<?php

namespace App\Http\Requests\Applicant;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [

            'position' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required',
            'address_line_1' => 'required',
            'address_line_2' => 'nullable',
            'city' => 'required',
            'county' => 'nullable',
            'postcode' => 'required',
            'mobile' => 'required',
            'landline' => 'nullable',
            'national_insurance_number' => 'nullable',
            'nurse_pin_number' => 'nullable',
            'right_to_work' => 'nullable',
            'qualifications' => 'nullable',
            'most_recent_work' => 'nullable',
            'relevant_skills' => 'nullable',
            'referees' => 'nullable',
            'drivers_license' => 'nullable',
            'in_good_health' => 'nullable',
            'good_health_information' => 'nullable',
            'offender' => 'nullable',
            'offender_information' => 'nullable',
            'status' => 'nullable',
            'source' => 'nullable',
            'branch_id' => 'nullable',
            'hired' => 'nullable',
            'declaration' => 'nullable',
            'skills'=>'nullable',
            'shifts'=> 'nullable',
            'experience'=> 'nullable'
        ];
    }
}
