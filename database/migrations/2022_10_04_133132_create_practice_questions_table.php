<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePracticeQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('practice_questions', function (Blueprint $table) {
            $table->id();
            $table->string('Question');
            $table->string('QuestionAr');
            $table->string('QuestionIn')->nullable();
            $table->integer('PracticeId');
            $table->integer('Respondent');
            $table->integer('ordering')->nullable();
            $table->boolean('Status');
            $table->boolean('IsENPS');
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
        Schema::dropIfExists('practice_questions');
    }
}
