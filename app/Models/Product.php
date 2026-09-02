<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'barcode',
        'category',
        'unit',
        'price',
        'stock_quantity',
        'reference_stock',
        'low_stock_threshold',
        'status',
        'is_active',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    public function saleItems()
    {
        return $this->hasMany(SaleItem::class);
    }
        public function stockInflows()
    {
        return $this->hasMany(StockInflow::class);
    }

    public function stockOutflows()
    {
        return $this->hasMany(StockOutflow::class);
    }

    public function stockAdjustments()
    {
        return $this->hasMany(StockAdjustment::class);
    }

    public function expiredDamagedGoods()
    {
        return $this->hasMany(ExpiredDamagedGood::class);
    }
}