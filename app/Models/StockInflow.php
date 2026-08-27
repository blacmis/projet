<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockInflow extends Model
{
    protected $fillable = [
        'product_id', 'supplier_id', 'batch_no', 'quantity',
        'unit_cost', 'total_value', 'date_received', 'expiry_date',
    ];

    protected $casts = [
        'unit_cost' => 'decimal:2',
        'total_value' => 'decimal:2',
        'date_received' => 'date',
        'expiry_date' => 'date',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
}