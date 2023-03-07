<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\PrioritiesAnswers;

class PrioritiesAnswersFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PrioritiesAnswers::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'SurveyId' => $this->faker->numberBetween(-10000, 10000),
            'QuestionId' => $this->faker->numberBetween(-10000, 10000),
            'AnswerValue' => $this->faker->numberBetween(-10000, 10000),
            'AnsweredBy' => $this->faker->numberBetween(-10000, 10000),
        ];
    }
}
