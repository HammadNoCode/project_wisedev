<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRgnToComplianceDocuments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('compliance_documents', function (Blueprint $table) {
            $table->tinyInteger('rng')->nullable(true)->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('compliance_documents', function (Blueprint $table) {
            $table->tinyInteger('rng')->nullable(true)->default(0);
        });
    }
}
