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
        Schema::create('email_contents', function (Blueprint $table) {
            $table->id();
            $table->integer('client_id');
            $table->integer('survey_id');
            $table->longText('body_header');
            $table->longText('body_footer');
            $table->text('subject');
            $table->longText('body_header_ar')->nullable();
            $table->longText('body_footer_ar')->nullable();
            $table->text('subject_ar')->nullable();
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
        Schema::dropIfExists('email_contents');
    }
};
