<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\StockTransaction;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProductProduced>
 */
class ProductProducedFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
          'quantity_produced' => $this->faker->randomNumber(),
           'product_id' =>Product::inRandomOrder()->first()->id,
           'user_id' =>User::inRandomOrder()->first()->id,
           'stock_transaction_id' =>StockTransaction::inRandomOrder()->first()->id,
        ];
    }
}
