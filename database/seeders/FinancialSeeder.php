<?php

namespace Database\Seeders;

use App\Models\Financial;
use App\Models\Invoice;
use App\Models\SalesOrder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FinancialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $salesOrders = SalesOrder::factory();
        $invoice = Invoice::factory()->for( $salesOrders );
     

        Financial::factory()->count(25)->for( $invoice )->create();
    }
}
