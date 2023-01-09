<?php

namespace Tests\Feature\Livewire;

use App\Http\Livewire\Financial\Table;
use App\Models\Financial;
use App\Models\Invoice;
use App\Models\User;
use App\Traits\FeatureTestTrait;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Livewire\Livewire;
use Tests\TestCase;

class FinancialTest extends TestCase
{
    use FeatureTestTrait, AuthorizesRequests;

         /** @test  */
    
         public function authorized_user_can_view_financials()
         {
             $this->withoutExceptionHandling();

             $invoice=Invoice::factory()->create();

             $financial=Financial::factory(5)->for($invoice)->create();

             $user = User::factory()->create();
            
             $user->assignRole('Admin');
 
             Livewire::actingAs($user)
                 ->test(Table::class)->assertSee( $financial->first()->expenses);
         }

                  /** @test  */
    
                  public function unauthorized_user_can_not_view_financials()
                  {
                     
         
                      $invoice=Invoice::factory()->create();
         
                      $financial=Financial::factory(5)->for($invoice)->create();
         
                      $user = User::factory()->create();
                     
                      $user->assignRole('Employee');
          
                      Livewire::actingAs($user)
                          ->test('financial.table')->assertStatus(Response::HTTP_FORBIDDEN);
                  }

}
