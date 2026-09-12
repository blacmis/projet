<?php

namespace App\Models;

use App\Concerns\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use BelongsToTenant;

    protected $fillable = [
        'store_name', 'store_address', 'store_phone', 'currency',
        'tax_rate', 'receipt_footer', 'low_stock_threshold', 'expiry_alert_days',
    ];
}