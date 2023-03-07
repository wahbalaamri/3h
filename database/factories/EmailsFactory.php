<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Emails;

class EmailsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Emails::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'ClientId' => $this->faker->numberBetween(-10000, 10000),
            'Email' => $this->faker->word,
            'EmployeeType' => $this->faker->numberBetween(-10000, 10000),
            'AddedBy' => $this->faker->numberBetween(-10000, 10000),
        ];
    }
}
