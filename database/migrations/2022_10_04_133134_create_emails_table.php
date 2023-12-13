<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('emails', function (Blueprint $table) {
            $table->uuid('id')->primary();
            //department
            $table->integer('dep_id');
            $table->integer('ClientId');
            $table->integer('comp_id')->nullable();
            $table->integer('sector_id')->nullable();
            $table->integer('SurveyId');
            $table->string('Email')->nullable();
            $table->string('Mobile')->nullable();
            $table->string('Emp_id')->nullable();
            $table->string('gender')->nullable();
            $table->string('age_generation')->nullable();
            $table->integer('EmployeeType');
            $table->integer('AddedBy');
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
        Schema::dropIfExists('emails');
    }
}
