<?php

namespace App\Http\Controllers\Admin\Concerns;

use App\Models\Product;
use App\Models\StockInflow;
use App\Models\ExpiredDamagedGood;

trait HasInventoryStats
{
    protected function inventoryStats(): object
    {
        $lowStock = Product::whereColumn('stock_quantity', '<=', 'low_stock_threshold')
            ->where('stock_quantity', '>', 0)
            ->count();

        $expiringSoon = StockInflow::whereNotNull('expiry_date')
            ->whereBetween('expiry_date', [today(), today()->addDays(7)])
            ->distinct('product_id')
            ->count('product_id');

        $expired = ExpiredDamagedGood::where('type', 'expired')
            ->distinct('product_id')
            ->count('product_id');

        return (object) [
            'total_products' => Product::count(),
            'available_products' => Product::where('is_active', true)->count(),
            'unavailable_products' => Product::where('is_active', false)->count(),
            'low_stock' => $lowStock,
            'expiring_soon' => $expiringSoon,
            'expired' => $expired,
        ];
    }
}