<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id')->nullable(false);
            $table->string('name')->nullable(false);
            $table->string('password')->nullable(false);
            $table->string('email')->unique()->nullable(false);
            $table->string('telephone')->nullable();
            $table->integer('verified')->nullable(false)->default(0);
            $table->integer('manager')->nullable(false)->default(0);
            $table->integer('compliance_manager')->nullable(false)->default(0);
            $table->integer('administrator')->nullable(false)->default(0);
            $table->string('position')->nullable();
            $table->integer('department')->nullable(false)->default(1);
            $table->integer('branch_id')->nullable()->default(0);
            $table->integer('deleted')->nullable(false)->default(0);
            $table->integer('test')->nullable(false)->default(0);
            $table->rememberToken();
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
