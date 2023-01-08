<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;
    
    protected $table = 'inventory';

    public function purchaseOrders()
    {
        return $this->belongsToMany(PurchaseOrder::class);
    }

    public function salesOrders()
    {
        return $this->belongsToMany(SalesOrder::class);
    }
}
