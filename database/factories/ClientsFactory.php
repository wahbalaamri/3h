<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Clients;

class ClientsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Clients::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'ClientName' => $this->faker->word,
            'ClientEmail' => $this->faker->word,
            'ClientPhone' => $this->faker->word,
            'CilentFPName' => $this->faker->word,
            'CilentFPEmil' => $this->faker->word,
            'CilentFPPhone' => $this->faker->word,
        ];
    }
}
