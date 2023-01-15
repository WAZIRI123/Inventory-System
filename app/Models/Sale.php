<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Sale extends Model
{
    use HasFactory;

    protected $fillable=[];

    
    public function product():BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
