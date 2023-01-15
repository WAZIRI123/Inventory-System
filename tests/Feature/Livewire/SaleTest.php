<?php

namespace Tests\Feature\Livewire;

use App\Http\Livewire\Sales\Create;
use App\Models\Product;
use App\Models\User;
use App\Traits\FeatureTestTrait;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class SaleTest extends TestCase


{
    use RefreshDatabase;
    use FeatureTestTrait, AuthorizesRequests;

      /** @test  */

      public function authorized_admin_can_create_product()
      {
        
         $this->withoutExceptionHandling();
     
          // make fake user && assign permission && acting as that user
     
          $user = User::factory()->create();
          $product = Product::factory()->create();

          /** @var \Illuminate\Contracts\Auth\Authenticatable $user */
          $this->actingAs($user);
     
          // test 
          Livewire::test(Create::class)
              ->set('item.quantity', 20)
              ->set('item.product_id', $product->id)
              ->set('item.employee_id', $user->id)
              ->call('createItem')->assertHasNoErrors();
     
          // test if data exist in database

          $this->assertEquals($product->inStock(),20);
     
          $this->assertDatabaseHas('sales', [
             'quantity' =>20,
             'product_id' =>  $product->id,
         ]);

     
      }
}
