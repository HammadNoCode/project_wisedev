<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBranchReportingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('branch_reporting', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('branch_id')->nullable(false);
            $table->string('position')->nullable(false);
            $table->tinyInteger('hours_achieved')->nullable(true);
            $table->tinyInteger('hours_lost')->nullable(true);
            $table->date('week_commencing')->nullable(false);
            $table->date('week_ending')->nullable(false);
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
