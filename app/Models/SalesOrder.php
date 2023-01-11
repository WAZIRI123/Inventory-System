<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class SalesOrder extends Model
{
    use HasFactory;
    protected $table = 'sales';

    protected $fillable = [
        'customer_name',
        'order_date',
        'delivery_date',

    ];

    public function invoice()
    {
        return $this->hasOne(Invoice::class);
    }

    public function items()
    {
        return $this->belongsToMany(Inventory::class,'inventory_sales_order');
    }
}
