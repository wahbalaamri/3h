<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Surveys;

class SurveysFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Surveys::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'ClientId' => $this->faker->numberBetween(-10000, 10000),
            'SurveyTitle' => $this->faker->word,
            'SurveyDes' => $this->faker->text,
            'SurveyStat' => $this->faker->boolean,
        ];
    }
}
