<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Invoice>
 */
class InvoiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'invoice_date' => $this->faker->dateTime,
            'sales_order_id' => $this->faker->randomDigit(),
            'total_amount' => $this->faker->randomFloat(2, 100, 10000),
        ];
    }
}
