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
        Schema::create('open_ended_questions', function (Blueprint $table) {
            $table->id();
            $table->string('question');
            $table->string('question_ar')->nullable();
            $table->string('question_in')->nullable();
            $table->integer('survey_id');
            $table->integer('respondent')->nullable();
            $table->boolean('status')->default(true);
            $table->string('answer_type');
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
        Schema::dropIfExists('open_ended_questions');
    }
};
