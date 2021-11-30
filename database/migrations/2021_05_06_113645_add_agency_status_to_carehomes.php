<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAgencyStatusToCarehomes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('carehomes', function (Blueprint $table) {
            $table->string('agency_status')->nullable(true); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('carehomes', function (Blueprint $table) {
            $table->string('agency_status')->nullable(true);
        });
    }
}
