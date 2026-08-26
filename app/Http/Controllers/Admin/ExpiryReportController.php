<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ExpiryReportController extends Controller
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
            (object) ['product_code' => '00001', 'product_name' => 'Coca-Cola 1L', 'category' => 'Beverage', 'batch_no' => '#346555', 'unit_price' => 400, 'quantity' => 100, 'expiry_date' => '06-08-2026', 'days_left' => '2 days', 'total_value' => 40000, 'status' => 'Expiring Soon'],
            (object) ['product_code' => '00002', 'product_name' => 'Rice 50kg', 'category' => 'Grains', 'batch_no' => '#250101', 'unit_price' => 10000, 'quantity' => 30, 'expiry_date' => '08-08-2026', 'days_left' => '4 days', 'total_value' => 300000, 'status' => 'Expiring Soon'],
            (object) ['product_code' => '00003', 'product_name' => 'Sardine', 'category' => 'Beverage', 'batch_no' => '030012', 'unit_price' => 350, 'quantity' => 10, 'expiry_date' => '12-08-2026', 'days_left' => '8 days', 'total_value' => 3500, 'status' => 'Out-Of-Stock'],
            (object) ['product_code' => '00004', 'product_name' => 'Detol Soap', 'category' => 'Household', 'batch_no' => '#250105', 'unit_price' => 1500, 'quantity' => 50, 'expiry_date' => '20-08-2026', 'days_left' => '16 days', 'total_value' => 75000, 'status' => 'Within 30days'],
            (object) ['product_code' => '00005', 'product_name' => 'Chicken Egg(30pcs)', 'category' => 'Groceries', 'batch_no' => '#250020', 'unit_price' => 1800, 'quantity' => 30, 'expiry_date' => '24-08-2026', 'days_left' => '20 days', 'total_value' => 54000, 'status' => 'Within 30days'],
        ]);

        if ($request->filled('category') && $request->category !== 'all') {
            $items = $items->where('category', $request->category)->values();
        }
        if ($request->filled('status') && $request->status !== 'all') {
            $items = $items->where('status', $request->status)->values();
        }

        return view('admin.expiry-report', compact('stats', 'items'));
    }
}