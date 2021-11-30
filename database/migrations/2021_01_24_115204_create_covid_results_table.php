<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCovidResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('covid_results', function (Blueprint $table) {
            $table->id();
            $table->integer('staff_id');
            $table->string('first_name');
            $table->string('last_name');
            $table->integer('covid_result');
            $table->date('test_date');
            $table->string('test_type');
            $table->string('type_of_other_test');
            $table->string('display_name');
            $table->string('filename');
            $table->string('url');
            $table->boolean('archived');
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
