<?php

namespace Tests\Feature\Livewire;

use App\Http\Livewire\Product\Create;
use App\Models\User;
use App\Models\Vendor;
use App\Traits\FeatureTestTrait;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;
    use FeatureTestTrait, AuthorizesRequests;


      /** @test  */

 public function authorized_admin_can_create_product()
 {
   
    $this->withoutExceptionHandling();

     // make fake user && assign permission && acting as that user

     $user = User::factory()->create();
     $vendor = Vendor::factory()->create();
     $user->assignRole('Admin');
     /** @var \Illuminate\Contracts\Auth\Authenticatable $user */
     $this->actingAs($user);

     // test 
     Livewire::test(Create::class)
         ->set('item.name', 'John Doe')
         ->set('item.vendor_id', $vendor->id)
         ->set('item.description', 'product test')
         ->set('item.purchase_price', 20)
         ->set('item.sale_price', 50)
         ->set('item.quantity', 2)
         ->call('createItem')->assertHasNoErrors();

     // test if data exist in database

     $this->assertDatabaseHas('products', [
        'name' => 'John Doe',
        'vendor_id' =>  $vendor->id,
    ]);

 }

}
