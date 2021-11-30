<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CallScheduleTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        if(!Schema::connection('staff')->hasTable('call_schedule')) {
            Schema::connection('staff')->create('call_schedule', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('title');
                $table->unsignedBigInteger('staff_id');
                $table->string('path');
                $table->integer('outcome');
                $table->dateTime('scheduled');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
    }
}