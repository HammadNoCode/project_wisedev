<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->integer('branch_id');
            $table->string('type');
            $table->string('agenda');
            $table->string('attendee_type');
            $table->time('time');
            $table->date('date');
            $table->string('location');
            $table->string('postcode');
            $table->string('address');
            $table->integer('capacity');
            $table->integer('expired');
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
