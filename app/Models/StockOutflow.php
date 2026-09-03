<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockOutflow extends Model
{
    protected $fillable = [
        'product_id', 'type', 'quantity', 'unit_cost', 'total_value', 'date', 'reason',
    ];

    protected $casts = [
        'unit_cost' => 'decimal:2',
        'total_value' => 'decimal:2',
        'date' => 'date',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}