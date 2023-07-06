<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Branch;
use App\Models\Employee;
use App\Models\Product;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
 
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Branch::create([
            'name' => 'Kipanga New Eagle Bar',
           
        ]);
        Branch::create([
            'name' => 'Kili Time Bar',
           
        ]);
        Product::factory()->count(3)->create();
        $this->call([
            RolesSeeder::class,
            userSeeder::class,
            EmployeeSeeder::class ,
            VendorSeeder::class,
        ]);
    }
}
