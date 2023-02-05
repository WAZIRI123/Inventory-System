<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\ProductType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Purchase>
 */
class PurchaseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $productId=Product::inRandomOrder()->first()->id;
        return [
            'purchase_price' => $this->faker->randomFloat(2, 0, 1000),
            'product_id' =>$productId ,
            'quantity' => $this->faker->numberBetween(1, 100),
        ];
    }
}
