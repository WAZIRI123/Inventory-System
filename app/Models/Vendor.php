<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Vendor extends Model
{
    use HasFactory;
    
    protected $table = 'vendors';

    public function purchaseOrders()
    {
        return $this->hasMany(PurchaseOrder::class);
    }
}
