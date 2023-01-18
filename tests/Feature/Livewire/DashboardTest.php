<?php

namespace Tests\Feature\Livewire;

use App\Http\Livewire\Index;
use App\Models\Employee;
use App\Models\Product;
use App\Models\Sale;
use App\Models\User;
use App\Traits\FeatureTestTrait;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    use RefreshDatabase;
    use FeatureTestTrait, AuthorizesRequests;

     public function testTotalRevenue()
     {
        $this->withoutExceptionHandling();
         Employee::factory()->create();
         Product::factory()->create(['sale_price' => 10]);
 
        Sale:: factory(2)->create([
             'product_id' => 1,
             'quantity' => 3
         ]);
         $user = User::factory()->create();

         $user->assignRole('Admin');

         Livewire::test(Index::class)
        
             ->assertSet('totalRevenue', 60)
             ->assertSet('totalProducts', 3)
             ->assertSet('outOfStock', 3)
             ->assertSet('totalEmployees', 3);

     }
}
