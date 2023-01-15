<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Sale extends Model
{
    use HasFactory;

    protected $fillable=['product_id','quantity','employee_id'];

    
    public function product():BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function employee():BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

}
