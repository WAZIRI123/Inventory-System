<?php

namespace Tests\Feature\Livewire;

use App\Http\Livewire\Employee\Create;
use App\Models\Employee;
use App\Models\User;
use App\Traits\FeatureTestTrait;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Tests\TestCase;

class EmployeeTest extends TestCase
{
    use RefreshDatabase;
    use FeatureTestTrait, AuthorizesRequests;

     /** @test  */

 public function authorized_admin_can_create_employee()
 {
   
    $this->withoutExceptionHandling();
     //make fake disk
     Storage::fake('public');

     // make fake image
     $imagename = 'post-image.png';
     $image = UploadedFile::fake()->image($imagename);

     // make fake user && assign permission && acting as that user

     $user = User::factory()->create();
     $user->assignRole('Admin');
     /** @var \Illuminate\Contracts\Auth\Authenticatable $user */
     $this->actingAs($user);

     // test 
     Livewire::test(Create::class)
         ->set('item.name', 'waziri')
         ->set('profile_picture', $image)
         ->set('item.email', 'waziriallyami@gmail.com')
         ->call('createItem');

     // test if data exist in database
     $this->assertDatabaseHas('employees', [
         'user_id' =>  2
     ]);
 }

  //test authorised users can edit employee
  public function test_authorised_users_can_edit_employee()
  {
      $this->withoutExceptionHandling();
 
      //make fake disk
      Storage::fake('public');
 
      // make fake image
      $imagename = 'post-image.png';
      Storage::disk('public')
          ->putFileAs('', UploadedFile::fake()->image($imagename), $imagename);
 
      // make fake user && assign role && acting as that user
      $user1 = User::factory()->create(['profile_picture' => $imagename, 'remember_token' => null]);
      $user1->assignRole('Admin');
      $employee = Employee::factory()->for($user1)->create();

 
      // make fake image2
      $imagename2 = 'post-image2.png';
      $image2 = UploadedFile::fake()->image($imagename2);
 
      // test
      Livewire::actingAs($user1)
          ->test(Create::class, ['item' => $employee, 'oldImage' => $employee->user->profile_picture])
          ->call('showEditForm', $employee)
 
          ->set('profile_picture', $image2)
 
          ->call('editItem', $employee);
 
      $this->assertDatabaseHas('users', [
          'profile_picture' => 'img/profile_picture/upload/' . $imagename2
      ]);
 
      // test if image exist and match updated one
      Storage::disk('public')->assertMissing('img/profile_picture/upload/' . $imagename);
 
      Storage::disk('public')->assertExists('img/profile_picture/upload/' . $imagename2);
  }

   //test authorised users can edit employee

 public function test_authorised_users_can_delete_employee()
 {
     // make fake user && assign role && acting as that user
     $user = User::factory()->create();
     $user->assignRole('Admin');
   
     $employee = Employee::factory()->for($user)->create();

     // test
     Livewire::actingAs($user)
         ->test(Create::class, ['employee' => $employee])
         ->call('showDeleteForm',$employee)
         ->call('deleteItem', $employee);

     // test if data is softdeleted
     $this->assertSoftDeleted($employee);
 }


}
