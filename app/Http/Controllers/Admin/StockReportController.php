<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StockReportController extends Controller
{
    public function index(Request $request)
    {
        $stats = (object) [
            'total_products' => 1245,
            'available_products' => 1200,
            'unavailable_products' => 45,
            'low_stock' => 24,
            'expiring_soon' => 18,
            'expired' => 7,
        ];

        $summary = collect([
            (object) ['category' => 'Groceries', 'total_products' => 245, 'available_stock' => 3120, 'sold_stock' => 5860, 'stock_value_available' => 98650, 'stock_value_sold' => 176000, 'status' => 'In Stock'],
            (object) ['category' => 'Beverages', 'total_products' => 120, 'available_stock' => 1850, 'sold_stock' => 3415, 'stock_value_available' => 48520, 'stock_value_sold' => 96150, 'status' => 'In Stock'],
            (object) ['category' => 'Dairy', 'total_products' => 95, 'available_stock' => 880, 'sold_stock' => 2540, 'stock_value_available' => 32415, 'stock_value_sold' => 81280, 'status' => 'In Stock'],
            (object) ['category' => 'Health & Beauty', 'total_products' => 70, 'available_stock' => 890, 'sold_stock' => 1230, 'stock_value_available' => 28300, 'stock_value_sold' => 57360, 'status' => 'Low Stock'],
            (object) ['category' => 'Household', 'total_products' => 55, 'available_stock' => 660, 'sold_stock' => 1520, 'stock_value_available' => 21565, 'stock_value_sold' => 42760, 'status' => 'Low Stock'],
        ]);

        if ($request->filled('category') && $request->category !== 'all') {
            $summary = $summary->where('category', $request->category)->values();
        }
        if ($request->filled('status') && $request->status !== 'all') {
            $summary = $summary->where('status', $request->status)->values();
        }

        $topAvailable = collect([
            (object) ['code' => '00001', 'name' => 'Coca-Cola 1L', 'category' => 'Beverage', 'qty' => 100, 'unit_price' => 400, 'stock_value' => 40000],
            (object) ['code' => '00002', 'name' => 'Rice 50kg', 'category' => 'Grains', 'qty' => 30, 'unit_price' => 10000, 'stock_value' => 300000],
            (object) ['code' => '00003', 'name' => 'Sardine', 'category' => 'Beverage', 'qty' => 10, 'unit_price' => 350, 'stock_value' => 3500],
            (object) ['code' => '00004', 'name' => 'Detol Soap', 'category' => 'Household', 'qty' => 50, 'unit_price' => 1500, 'stock_value' => 75000],
            (object) ['code' => '00005', 'name' => 'Chicken Egg(30pcs)', 'category' => 'Groceries', 'qty' => 30, 'unit_price' => 1800, 'stock_value' => 54000],
        ]);

        $topSold = collect([
            (object) ['code' => '00001', 'name' => 'Coca-Cola 1L', 'category' => 'Beverage', 'qty' => 200, 'unit_price' => 400, 'total_sales' => 80000],
            (object) ['code' => '00002', 'name' => 'Rice 50kg', 'category' => 'Grains', 'qty' => 100, 'unit_price' => 10000, 'total_sales' => 1000000],
            (object) ['code' => '00003', 'name' => 'Sardine', 'category' => 'Beverage', 'qty' => 340, 'unit_price' => 350, 'total_sales' => 119000],
            (object) ['code' => '00004', 'name' => 'Detol Soap', 'category' => 'Household', 'qty' => 50, 'unit_price' => 1500, 'total_sales' => 75000],
            (object) ['code' => '00005', 'name' => 'Chicken Egg(30pcs)', 'category' => 'Groceries', 'qty' => 100, 'unit_price' => 1800, 'total_sales' => 180000],
        ]);

        return view('admin.stock-report', compact('stats', 'summary', 'topAvailable', 'topSold'));
    }
}