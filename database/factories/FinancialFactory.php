<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Financial>
 */
class FinancialFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'revenue' => $this->faker->randomFloat(2, 100, 10000),
            'expenses' => $this->faker->randomFloat(2, 100, 10000),
            'profit' => $this->faker->randomFloat(2, 100, 10000),
        ];
    }
}
