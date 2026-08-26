<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class InventoryReportController extends Controller
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

        $items = collect([
            (object) ['product_code' => '00001', 'product_name' => 'Coca Cola 1L', 'category' => 'Beverage', 'date' => '23-07-2026', 'unit_price' => 400, 'total_stock' => 300, 'sold_stock' => 200, 'available_stock' => 100, 'status' => 'In Stock', 'expiry_date' => '25-07-2027', 'inventory_value' => 40000, 'supplier' => 'ABC Foods Ltd'],
            (object) ['product_code' => '00002', 'product_name' => 'Rice 50kg', 'category' => 'Grains', 'date' => '27-07-2025', 'unit_price' => 10000, 'total_stock' => 220, 'sold_stock' => 190, 'available_stock' => 30, 'status' => 'Low Stock', 'expiry_date' => '27-03-2029', 'inventory_value' => 300000, 'supplier' => 'Hilton Foods'],
            (object) ['product_code' => '00003', 'product_name' => 'Sardine', 'category' => 'Beverage', 'date' => '16-09-2025', 'unit_price' => 350, 'total_stock' => 350, 'sold_stock' => 340, 'available_stock' => 10, 'status' => 'Out-Of-Stock', 'expiry_date' => '18-09-2028', 'inventory_value' => 3500, 'supplier' => 'Jasmine Food'],
            (object) ['product_code' => '00004', 'product_name' => 'Detol Soap', 'category' => 'Household', 'date' => '25-12-2024', 'unit_price' => 1500, 'total_stock' => 100, 'sold_stock' => 50, 'available_stock' => 50, 'status' => 'In Stock', 'expiry_date' => '30-12-2026', 'inventory_value' => 75000, 'supplier' => 'Detol Ltd'],
            (object) ['product_code' => '00005', 'product_name' => 'Chicken Egg(30pcs)', 'category' => 'Groceries', 'date' => '28-08-2026', 'unit_price' => 1800, 'total_stock' => 120, 'sold_stock' => 100, 'available_stock' => 20, 'status' => 'Low Stock', 'expiry_date' => '28-09-2026', 'inventory_value' => 36000, 'supplier' => 'Chang Farmers Ltd'],
        ]);

        if ($request->filled('category') && $request->category !== 'all') {
            $items = $items->where('category', $request->category)->values();
        }
        if ($request->filled('supplier') && $request->supplier !== 'all') {
            $items = $items->where('supplier', $request->supplier)->values();
        }
        if ($request->filled('status') && $request->status !== 'all') {
            $items = $items->where('status', $request->status)->values();
        }

        return view('admin.inventory-report', compact('stats', 'items'));
    }
}