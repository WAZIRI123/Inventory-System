<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Inventory>
 */
class InventoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' =>  $this->faker->word,
            'description' =>  $this->faker->text,
            'quantity' =>  $this->faker->numberBetween(1, 100),
            'unit' => 'each',
            'location' =>  $this->faker->city,
        ];
    }
}
