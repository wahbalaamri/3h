<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\FunctionPractice;

class FunctionPracticeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = FunctionPractice::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'PracticeTitle' => $this->faker->word,
            'PracticeTitleAr' => $this->faker->word,
            'FunctionId' => $this->faker->numberBetween(-10000, 10000),
            'Status' => $this->faker->boolean,
        ];
    }
}
