<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStaffOnboardingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('staff_onboarding', function (Blueprint $table) {
            $table->id();
            $table->string('full_name')->nullable(false);
            $table->string('email_address')->nullable(false);
            $table->string('address_line_1')->nullable(false);
            $table->string('address_line_2')->nullable(true);
            $table->string('postcode')->nullable(false);
            $table->string('town')->nullable(true);
            $table->string('mobile_number')->nullable(true);
            $table->string('home_number')->nullable(true);
            $table->string('marital_status')->nullable(false);
            $table->string('gender')->nullable(false);
            $table->string('date_of_birth')->nullable(true);
            $table->string('national_insurance_number')->nullable(true);
            $table->string('bank')->nullable(false);
            $table->string('account_title')->nullable(false);
            $table->string('account_number')->nullable(false);
            $table->string('passport_number')->nullable(false);
            $table->string('sort_code')->nullable(false);
            $table->string('payslip_access_password')->nullable(false);
            $table->string('payslip_access_email')->nullable(false);
            $table->string('emergency_contact_name')->nullable(false);
            $table->string('emergency_contact_number')->nullable(false);
            $table->string('emergency_contact_relation')->nullable(false);
            $table->string('terms_&_conditions')->nullable(false);
            $table->string('onboarding_date')->nullable(false);
            $table->string('print_name')->nullable(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Schema::dropIfExists('staff_onboarding');
    }
}
