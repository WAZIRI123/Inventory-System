<?php

namespace Database\Factories;

use App\Models\Vendor;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
        'name' => $this->faker->name,
        'sku' => $this->faker->uuid,
        'plates_quantity' => $this->faker->randomNumber(),
        'sale_price' => $this->faker->randomFloat(2, 0, 999),
            
        ];
    }
}
