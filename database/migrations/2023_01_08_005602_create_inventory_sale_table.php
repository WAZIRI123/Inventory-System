<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventory_sales_order', function (Blueprint $table) {
            $table->unsignedBigInteger('inventory_id');
            $table->unsignedBigInteger('sales_order_id');
            $table->primary(['inventory_id', 'sales_order_id']);

            $table->foreign('inventory_id')->references('id')->on('inventory')->onDelete('cascade');
            $table->foreign('sales_order_id')->references('id')->on('sales')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inventory_sale');
    }
};
