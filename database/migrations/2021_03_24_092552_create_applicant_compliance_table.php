<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApplicantComplianceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('applicant_compliance', function (Blueprint $table) {
            $table->id();
            $table->integer('document_id')->nullable();
            $table->integer('applicant_id')->nullable();
            $table->date('issue_date')->nullable();
            $table->date('renewal_date')->nullable();
            $table->date('expiry_date')->nullable();
            $table->integer('expired')->nullable()->default(0);
            $table->integer('checked_by')->nullable();
            $table->integer('test')->nullable()->default(0);
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
