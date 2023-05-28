<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //create departments table
        Schema::create('departments', function (Blueprint $table) {
            $table->id();
            //company id
            $table->unsignedBigInteger('company_id');
            // department name in english
            $table->string('dep_name_en');
            // department name in arabic
            $table->string('dep_name_ar');
            // department parent
            $table->unsignedBigInteger('parent_id')->nullable();
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
        Schema::dropIfExists('departments');
    }
};
