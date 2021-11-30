<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInterviewQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('interview_questions', function (Blueprint $table) {
            $table->id();
            $table->integer('applicant_id');
            $table->string('experience');
            $table->string('strengths');
            $table->string('exceed_example');
            $table->string('skills');
            $table->string('scenario_one');
            $table->string('scenario_two');
            $table->string('outcome');
            $table->string('shift_type');
            $table->string('shifts');
            $table->string('hobbies');
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
