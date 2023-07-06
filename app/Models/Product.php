<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Appstract\Stock\HasStock;
use BinaryCats\Sku\HasSku;

class Product extends Model
{
    use HasFactory,SoftDeletes,HasStock,HasSku;

    protected $fillable=['name','description','sale_price','purchase_price'];
    
 
    public function Purchases()
    {
        return $this->hasMany(Purchase::class);
    }
    public function sales()
    {
        return $this->hasMany(Sale::class);
    }
}
