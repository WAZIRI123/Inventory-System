<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Financial extends Model

{
    use HasFactory;
    protected $table = 'financials';

    protected $fillable = [
        'invoice_id',
        'revenue',
        'expenses',
        'profit',
    ];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }
}
