<?php

namespace Database\Seeders;

use App\Models\Invoice;
use App\Models\SalesOrder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InvoiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $salesOrders = SalesOrder::factory()->create();

        Invoice::factory()->count(25)->create(['sales_order_id'=>$salesOrders ]);
    }
}
