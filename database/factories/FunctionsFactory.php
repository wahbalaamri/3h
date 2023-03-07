<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Functions;

class FunctionsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Functions::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'FunctionTitle' => $this->faker->word,
            'FunctionTitleAr' => $this->faker->word,
            'PlanId' => $this->faker->numberBetween(-10000, 10000),
            'Respondent' => $this->faker->text,
            'Status' => $this->faker->boolean,
        ];
    }
}
