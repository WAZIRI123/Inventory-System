<?php

namespace Tests\Feature\Livewire;

use App\Http\Livewire\Product\Create;
use App\Models\Product;
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
         ->set('quantity', 20)
         ->set('item.sale_price', 50)
         ->call('createItem')->assertHasNoErrors();

         $this->assertDatabaseHas('stock_mutations', [
            'amount' =>20
        ]);
     // test if data exist in database!

     $this->assertDatabaseHas('products', [
        'name' => 'John Doe',
        'vendor_id' =>  $vendor->id,
    ]);

 }

    /** @test  */

    public function unauthorized_admin_can_not_create_product()
    {
      
        // make fake user && assign permission && acting as that user
   
        $user = User::factory()->create();
        $vendor = Vendor::factory()->create();

        /** @var \Illuminate\Contracts\Auth\Authenticatable $user */
        $this->actingAs($user);
   
        // test 
        Livewire::test(Create::class)
            ->set('item.name', 'John Doe')
            ->set('item.vendor_id', $vendor->id)
            ->set('item.description', 'product test')
            ->set('item.purchase_price', 20)
            ->set('item.sale_price', 50)
            ->set('quantity', 2)
            ->call('createItem')->assertForbidden();
    }

  //test authorised users can edit Product
  public function test_authorised_users_can_edit_product()
  {
      $this->withoutExceptionHandling();

 
      // make fake user && assign role && acting as that user
      $user1 = User::factory()->create();
      $user1->assignRole('Admin');
      $Product = Product::factory()->create();

      $Product->increaseStock(20);
      // test
      Livewire::actingAs($user1)
          ->test(Create::class, ['item' => $Product])
          ->call('showEditForm', $Product)

          ->set('quantity', 10)
          ->set('item.name', 'John Doe')
 
          ->call('editItem', $Product);
         // assert that the stock of the product is equal to the new quantity
         $this->assertEquals($Product->Stock(), 10);

      $this->assertDatabaseHas('products', [
          'name' => 'John Doe' 
      ]);


  }

    //test authorised users can edit Product
    public function test_unauthorised_user_can_not_edit_product()
    {
      
        // make fake user && assign role && acting as that user
        $user1 = User::factory()->create();
      
        $Product = Product::factory()->create();
   
        // test
        Livewire::actingAs($user1)
            ->test(Create::class, ['item' => $Product])
            ->call('showEditForm', $Product)
   
            ->set('item.name', 'John Doe')
   
            ->call('editItem', $Product)->assertForbidden();

   
    }
     //test authorised users can edit Product

 public function test_authorised_users_can_delete_product()
 {
     
    $this->withoutExceptionHandling();
    // make fake user && assign role && acting as that user
     $user = User::factory()->create();
     $user->assignRole('Admin');
   
     $Product = Product::factory()->create();

     $Product->increaseStock(10);

     // test
     Livewire::actingAs($user)
         ->test(Create::class, ['Product' => $Product])
         ->call('showDeleteForm', $Product)
         ->call('deleteItem',  $Product);
         $this->assertEquals($Product->Stock(), 0);
     // test if data is softdeleted
     $this->assertSoftDeleted( $Product);
 }

 public function test_unauthorised_user_can_not_delete_product()
 {
     
    // make fake user && assign role && acting as that user
     $user = User::factory()->create();

   
     $Product = Product::factory()->create();

     // test
     Livewire::actingAs($user)
         ->test(Create::class, ['Product' => $Product])
         ->call('showDeleteForm', $Product)
         ->call('deleteItem',  $Product)->assertForbidden();
 }

}
