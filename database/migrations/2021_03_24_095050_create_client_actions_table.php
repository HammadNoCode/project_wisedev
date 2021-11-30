<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientActionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('client_actions', function (Blueprint $table) {
            $table->id();
            $table->integer('client_id')->nullable();
            $table->string('name')->nullable();
            $table->string('assigned_to')->nullable();
            $table->date('deadline')->nullable();
            $table->date('completed_at')->nullable();
            $table->integer('test')->nullable();
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
