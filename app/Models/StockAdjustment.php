<?php

namespace App\Models;

use App\Concerns\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;

class StockAdjustment extends Model
{
    use BelongsToTenant;

    protected $fillable = ['product_id', 'type', 'quantity', 'reason', 'date'];

    protected $casts = ['date' => 'date'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}