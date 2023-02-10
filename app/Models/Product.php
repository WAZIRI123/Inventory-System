<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Appstract\Stock\HasStock;
use BinaryCats\Sku\HasSku;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Product extends Model
{
    use HasFactory, SoftDeletes, HasStock, HasSku;

    protected $fillable = [
        'name',
        'sku',
        'plates_quantity',
        'sale_price'
    ];

    protected $casts = [
        'plates_quantity' => 'integer',
    ];

    public function totalRevenue($productId)
    {

        return Sale::join('products', 'sales.product_id', '=', 'products.id')
            ->where('products.id', $productId)
            ->selectRaw('SUM(products.sale_price* sales.quantity) as totalRevenueAsMchele')
            ->first()->totalRevenueAsMchele;
    
    }
    public function stockTransaction()
    {
        return $this->hasOne(StockTransaction::class);
    }
}
