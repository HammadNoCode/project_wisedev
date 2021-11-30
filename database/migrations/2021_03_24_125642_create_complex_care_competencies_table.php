<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComplexCareCompetenciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('complex_care_competencies', function (Blueprint $table) {
            $table->id();
            $table->string('nurse_name')->nullable(false);
            $table->string('staff_name')->nullable(false);
            $table->string('displayname')->nullable();
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
    }
}
