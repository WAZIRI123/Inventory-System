<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sale extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'quantity',
        'product_id',
        'employee_id',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function user($employeeId)
    {
        return User::where('id',$employeeId)->get()->first()->name;
    }


    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }



}
