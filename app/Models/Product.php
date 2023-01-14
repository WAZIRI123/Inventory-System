<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Appstract\Stock\HasStock;

class Product extends Model
{
    use HasFactory,SoftDeletes,HasStock;

    protected $fillable=['name','vendor_id','description','purchase_price','sale_price','quantity'];
    
    public function vendor():BelongsTo
    {
        return $this->belongsTo(Vendor::class);
    }
}
