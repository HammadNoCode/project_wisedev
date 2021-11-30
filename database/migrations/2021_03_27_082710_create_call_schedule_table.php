<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCallScheduleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('call_schedule', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable(false);
            $table->bigInteger('staff_id')->nullable(false);
            $table->string('path')->nullable(false);
            $table->integer('outcome')->nullable(false);
            $table->dateTime('scheduled')->nullable(false);
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
