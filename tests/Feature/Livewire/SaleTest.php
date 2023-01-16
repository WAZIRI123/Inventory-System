<?php

namespace Tests\Feature\Livewire;

use App\Http\Livewire\Sales\Create;
use App\Models\Product;
use App\Models\Sale;
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

    public function authorized_admin_can_create_sale()
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

        $this->assertEquals($product->stock(), 0);

        $this->assertDatabaseHas('sales', [
            'quantity' => 20,
            'product_id' =>  $product->id,
        ]);
    }

    //test authorised users can edit Sale

    public function test_authorised_users_can_delete_sale()
    {

        $this->withoutExceptionHandling();
        // make fake user && assign role && acting as that user
        $user = User::factory()->create();

        $product = Product::factory()->create();

        $sale = Sale::factory()->for($product)->create(['quantity' => 20]);

        $product->increaseStock($sale->quantity);

        // test
        Livewire::actingAs($user)
            ->test(Create::class, ['sale' => $sale])
            ->call('showDeleteForm', $sale)
            ->call('deleteItem',  $sale);

        $product->decreaseStock($sale->quantity);

        $this->assertEquals($product->Stock(), 0);
        // test if data is softdeleted
        $this->assertSoftDeleted($sale);
    }

    public function test_authorised_users_can_edit_sale()
    {
        $this->withoutExceptionHandling();

        // make fake user && assign role && acting as that user
        $user1 = User::factory()->create();

        $product = Product::factory()->create();

        $product->increaseStock(40);

        $sale = Sale::factory()->for($product)->create(['quantity' => 20]);

        //decrease stock of product
        $product->decreaseStock($sale->quantity);
        
        // test
        Livewire::actingAs($user1)
            ->test(Create::class, ['sale' => $sale])
            ->call('showEditForm', $sale)

            ->set('item.quantity', 10)

            ->call('editItem', $sale);
        

        
        // assert that the stock of the product is equal to the new quantity
        $this->assertEquals($product->Stock(), 30);
    }
}
