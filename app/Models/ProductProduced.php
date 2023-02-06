<?php

namespace App\Models;

use Appstract\Stock\HasStock;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductProduced extends Model
{
    use HasFactory,HasStock;

    protected $fillable = [
        'product_id', 'quantity_produced', 'user_id', 'stock_transaction_id'
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function stockTransaction(): BelongsTo
    {
        return $this->belongsTo(StockTransaction::class);
    }
}
