<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarehomeKeyContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('carehome_key_contacts', function (Blueprint $table) {
            $table->id();
            $table->string('location_id')->nullable(false);
            $table->string('first_name')->nullable(false);
            $table->string('last_name')->nullable(true);
            $table->string('contact_no')->nullable(false);
            $table->string('position')->nullable(true);
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
