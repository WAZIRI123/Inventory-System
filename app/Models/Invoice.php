<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Invoice extends Model
{
    use HasFactory;
    protected $table = 'invoices';

    public function salesOrder()
    {
        return $this->belongsTo(SalesOrder::class);
    }

    public function financial()
    {
        return $this->hasOne(Financial::class);
    }
}
