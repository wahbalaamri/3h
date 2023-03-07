<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\PartnerShipPlans;

class PartnerShipPlansFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PartnerShipPlans::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'PlanTitle' => $this->faker->word,
            'Objective' => $this->faker->text,
            'Process' => $this->faker->text,
            'Report' => $this->faker->text,
            'DeliveryMode' => $this->faker->text,
            'Limitations' => $this->faker->text,
            'PlanTitleAr' => $this->faker->word,
            'ObjectiveAr' => $this->faker->text,
            'ProcessAr' => $this->faker->text,
            'ReportAr' => $this->faker->text,
            'DeliveryModeAr' => $this->faker->text,
            'LimitationsAr' => $this->faker->text,
            'Audience' => $this->faker->numberBetween(-10000, 10000),
            'TamplatePath' => $this->faker->word,
            'Price' => $this->faker->randomFloat(0, 0, 9999999999.),
            'PaymentMethod' => $this->faker->numberBetween(-10000, 10000),
            'Status' => $this->faker->boolean,
        ];
    }
}
