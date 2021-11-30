<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->integer('branch_id');
            $table->string('position');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email');
            $table->string('mobile');
            $table->string('landline');
            $table->string('address_line_1');
            $table->string('address_line_2');
            $table->string('city');
            $table->string('county');
            $table->string('postcode');
            $table->string('experience');
            $table->string('shifts');
            $table->string('national_insurance_number');
            $table->string('skills');
            $table->string('nurse_pin_number');
            $table->string('right_to_work');
            $table->string('qualifications');
            $table->string('most_recent_work');
            $table->string('relevant_skills');
            $table->string('employment_gaps');
            $table->string('referees');
            $table->string('contact_referee');
            $table->string('drivers_license');
            $table->string('in_good_health');
            $table->string('good_health_information');
            $table->string('offender');
            $table->string('offender_information');
            $table->boolean('vaccinated');
            $table->string('declaration');
            $table->string('token');
            $table->integer('status');
            $table->integer('hired');
            $table->timestamp('accept_date');
            $table->timestamp('hire_date');
            $table->string('notes');
            $table->integer('contacted');
            $table->integer('phoned');
            $table->integer('reminder_count');
            $table->string('source');
            $table->string('source_details');
            $table->string('job_id');
            $table->string('invite_token');
            $table->integer('test');
            $table->boolean('pulse');
            $table->integer('covid_reminders');
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
        Schema::table('applications', function (Blueprint $table) {
            $table->tinyInteger('favourite')->nullable(true)->default(0);
        });
    }
}
