<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class PurchaseOrder extends Model
{
    use HasFactory;
    protected $table = 'purchases';

    protected $fillable = [
        'vendor_id',
        'order_date',
        'delivery_date',

    ];

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    public function items()
    {
        return $this->belongsToMany(Inventory::class);
    }
}
