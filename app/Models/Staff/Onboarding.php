<?php

namespace App\Models\Staff;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Onboarding extends Model
{
    use HasFactory;

    protected $table = 'staff_onboarding';

    public function createOnboarding($request)
    {
        $this->full_name = $request['full_name'];
        $this->email_address = $request['email_address'];
        $this->address_line_1 = $request['address_line_1'];
        $this->address_line_2 = $request['address_line_2'];
        $this->postcode = $request['postcode'];
        $this->town = $request['town'];
        $this->mobile_number = $request['mobile_number'];
        $this->home_number = $request['home_number'];
        $this->marital_status = $request['marital_status'];
        $this->gender = $request['gender'];
        $this->date_of_birth = $request['date_of_birth'];
        $this->national_insurance_number = $request['national_insurance_number'];
        $this->bank = $request['bank'];
        $this->account_title = $request['account_title'];
        $this->account_number = $request['account_number'];
        $this->passport_number = $request['passport_number'];
        $this->sort_code = $request['sort_code'];
        $this->payslip_access_password = $request['payslip_access_password'];
        $this->payslip_access_email = $request['payslip_access_email'];
        $this->emergency_contact_name = $request['emergency_contact_name'];
        $this->emergency_contact_number = $request['emergency_contact_number'];
        $this->emergency_contact_relation = $request['emergency_contact_relation'];
        $this->terms_and_conditions = $request['terms_and_conditions'];
        $this->onboarding_date = $request['onboarding_date'];
        $this->print_name = $request['print_name'];
        $this->save();
        return $this;
    }
}
