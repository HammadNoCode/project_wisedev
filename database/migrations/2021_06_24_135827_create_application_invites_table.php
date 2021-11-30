<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApplicationInvitesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('application_invites', function (Blueprint $table) {
            $table->id();
            $table->string('position')->nullable(false);
            $table->string('first_name')->nullable(false);
            $table->string('last_name')->nullble(false);
            $table->string('email')->nullable(false);
            $table->string('telephone')->nullable(false);
            $table->string('hours_pw')->nullable(true);
            $table->string('driving_licence')->nullable(false);
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
