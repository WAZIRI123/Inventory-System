<?php

namespace Database\Factories;

use App\Models\Customer;
use App\Models\Employee;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Sale>
 */
class SaleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $product=Product::factory()->create();
        $employee=Employee::factory()->create();
        return [
            'product_id'=>$product->id,
            'employee_id'=>$employee->id,
            'quantity'=>$this->faker->numberBetween(1,10)
        ];
    }
}
