<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Vendor extends Model
{
    use HasFactory;
    
    protected $table = 'vendors';

    protected $fillable = [
        'name',
        'contact_name',
        'contact_email',
        'contact_phone',
        'payment_terms',

    ];

    public function purchaseOrders()
    {
        return $this->hasMany(PurchaseOrder::class);
    }
}
