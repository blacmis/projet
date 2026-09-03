<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExpiredDamagedGood extends Model
{
    protected $fillable = [
        'product_id', 'batch_no', 'type', 'quantity',
        'expiry_date', 'estimated_loss', 'status',
    ];

    protected $casts = [
        'expiry_date' => 'date',
        'estimated_loss' => 'decimal:2',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}