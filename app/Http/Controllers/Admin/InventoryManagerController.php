<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class InventoryManagerController extends Controller
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

        $products = collect([
            (object) ['id' => 1, 'product_code' => '001', 'product_name' => 'coca cola 50cl', 'category' => 'beverages', 'available_stock' => 85, 'sold_stock' => 65, 'min_stock' => 20, 'expiry_date' => '12/11/2027', 'status' => 'Good'],
            (object) ['id' => 2, 'product_code' => '002', 'product_name' => 'Rice 50kg', 'category' => 'grains', 'available_stock' => 150, 'sold_stock' => 120, 'min_stock' => 30, 'expiry_date' => '22/07/2027', 'status' => 'Good'],
            (object) ['id' => 3, 'product_code' => '003', 'product_name' => 'Bread Loaf', 'category' => 'bakery', 'available_stock' => 180, 'sold_stock' => 176, 'min_stock' => 4, 'expiry_date' => '29/07/2026', 'status' => 'Out of Stock'],
            (object) ['id' => 4, 'product_code' => '004', 'product_name' => 'Pick Milk', 'category' => 'beverages', 'available_stock' => 125, 'sold_stock' => 110, 'min_stock' => 15, 'expiry_date' => '12/11/2027', 'status' => 'Low Stock'],
        ]);

        if ($request->filled('category') && $request->category !== 'all') {
            $products = $products->where('category', $request->category)->values();
        }
        if ($request->filled('status') && $request->status !== 'all') {
            $products = $products->where('status', $request->status)->values();
        }

        return view('admin.inventory-manager', compact('stats', 'products'));
    }
}