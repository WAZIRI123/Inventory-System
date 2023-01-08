<?php

namespace Database\Seeders;

use App\Models\Inventory;
use App\Models\SalesOrder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SalesOrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $inventory = Inventory::all();

        SalesOrder::factory()->count(25)->create()->each(function ($salesOrder) use ($inventory) {
            $salesOrder->items()->attach($inventory->random(5));
            $salesOrder->save();
        });
    }
}
