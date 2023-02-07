<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Appstract\Stock\HasStock;
use BinaryCats\Sku\HasSku;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Product extends Model
{
    use HasFactory,SoftDeletes,HasStock,HasSku;

    protected $fillable = [
        'name',
        'sku',
        'plates_quantity',
        'sale_price'
    ];

    protected $casts = [
        'plates_quantity' => 'integer',
    ];

    public function productProduced():HasOne
    {
        return $this->hasOne(ProductProduced::class);
    }
}
