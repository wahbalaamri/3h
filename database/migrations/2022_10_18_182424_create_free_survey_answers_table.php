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
        Schema::create('free_survey_answers', function (Blueprint $table) {
            $table->id();
            $table->string('SurveyId');
            $table->integer('PlanId');
            $table->integer('QuestionId');
            $table->integer('Answer_value');
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
        Schema::dropIfExists('free_survey_answers');
    }
};
