<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarehomesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('carehomes', function (Blueprint $table) {
            $table->id();
            $table->string('location_id')->nullable(false);
            $table->string('name')->nullable(false);
            $table->string('address_1')->nullable(false);
            $table->string('postal_code')->nullable(false);
            $table->string('region')->nullable();
            $table->string('main_contact_number')->nullable(false);
            $table->string('beds')->nullable(false);
            $table->string('website')->nullable();
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
