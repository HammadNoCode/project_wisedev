<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClinicalStaffTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clinical_staff', function (Blueprint $table) {
            $table->id();
            $table->integer('staff_id');
            $table->integer('hired_by');
            $table->integer('covid_reminders');
            $table->integer('vaccination_invite');
            $table->integer('test');
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
    }
}
