<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComplianceDocumentDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('compliance_document_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('document_id');
            $table->integer('applicant_id');
            $table->string('dbs_number');
            $table->string('issue_date');
            $table->string('date_checked');
            $table->string('online');
            $table->string('passport_number');
            $table->string('passport_expiry');
            $table->string('visa_number');
            $table->string('visa_type');
            $table->string('hours');
            $table->string('visa_expiry');
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
