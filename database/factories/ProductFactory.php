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
       $vendor=Vendor::factory()->create();
        return [
            'name' => $this->faker->name,
            'description' => $this->faker->sentence,
            'purchase_price' =>$this->faker->numberBetween(1000,2000),
            'sale_price' => $this->faker->numberBetween(1500,2300),
        ];
    }
}
