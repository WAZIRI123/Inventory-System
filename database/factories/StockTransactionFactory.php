<?php

namespace Database\Factories;

use App\Models\Employee;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\StockTransaction>
 */
class StockTransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'product_id' =>Product::inRandomOrder()->first()->id,
            'employee_id' =>Employee::inRandomOrder()->first()->id,
            'quantity' => $this->faker->numberBetween(1, 100),

        ];
    }
}
