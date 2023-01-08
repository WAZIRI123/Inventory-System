<?php

namespace Database\Seeders;

use App\Models\Inventory;
use App\Models\PurchaseOrder;
use App\Models\Vendor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PurchaseOrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $vendors = Vendor::all();
        $inventory = Inventory::all();

        PurchaseOrder::factory()->count(25)->create()->each(function ($purchaseOrder) use ($vendors, $inventory) {
            $purchaseOrder->vendor()->associate($vendors->random());
            $purchaseOrder->items()->attach($inventory->random(5));
            $purchaseOrder->save();
        });
    }
}
