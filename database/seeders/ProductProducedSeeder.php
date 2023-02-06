<?php

namespace Database\Seeders;

use App\Models\ProductProduced;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductProducedSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ProductProduced::factory(5)->create();
    }
}
