<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

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
        $this->call([
            RolesSeeder::class,
            userSeeder::class,
            EmployeeSeeder::class ,
            ProductSeeder::class,
            ProductTypeSeeder::class,
            PurchaseSeeder::class,
            SaleSeeder::class,
            StockTransactionSeeder::class
        ]);
    }
}
