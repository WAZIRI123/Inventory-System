<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Vendor>
 */
class VendorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => $this->faker->company,
            'contact_name' => $this->faker->name,
            'contact_email' => $this->faker->email,
            'contact_phone' => $this->faker->phoneNumber,
            'payment_terms' => 'Net 30',
        ];
    }
}
