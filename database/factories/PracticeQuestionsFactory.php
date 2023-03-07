<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\PracticeQuestions;

class PracticeQuestionsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PracticeQuestions::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'Question' => $this->faker->word,
            'QuestionAr' => $this->faker->word,
            'PracticeId' => $this->faker->numberBetween(-10000, 10000),
            'Respondent' => $this->faker->numberBetween(-10000, 10000),
            'Status' => $this->faker->boolean,
        ];
    }
}
