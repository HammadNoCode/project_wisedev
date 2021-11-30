<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReferencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('references', function (Blueprint $table) {
            $table->id();
            $table->integer('applicant_id')->nullable();
            $table->integer('type')->nullable();
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('mobile')->nullable();
            $table->string('token')->nullable();
            $table->string('occupation')->nullable();
            $table->string('known_since')->nullable();
            $table->integer('related')->nullable();
            $table->string('capacity')->nullable();
            $table->string('safeguard_check')->nullable();
            $table->string('note')->nullable();
            $table->date('employed_from')->nullable();
            $table->date('employed_to')->nullable();
            $table->string('staff_note')->nullable();
            $table->string('status')->nullable();
            $table->integer('manually')->nullable();
            $table->integer('reminder_count')->nullable();
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
        // Schema::dropIfExists('staff_onboarding_documents');
    }
}
