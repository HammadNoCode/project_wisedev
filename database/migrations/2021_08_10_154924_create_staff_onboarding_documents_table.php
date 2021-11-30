<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStaffOnboardingDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('staff_onboarding_documents', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('onboarding_id')->nullable(false);
            $table->string('display_name')->nullable(false);
            $table->string('filename')->nullable(false);
            $table->string('url')->nullable(false);
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
