<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CashierOverviewController extends Controller
{
    public function index(Request $request)
    {
        $stats = (object) [
            'today_sales' => 96,
            'today_sales_change' => '+22% vs Yesterday',
            'today_revenue' => 4769000,
            'today_revenue_change' => '+20.6% vs Yesterday',
            'transactions' => 34,
        ];

        $products = collect([
            (object) ['product_code' => '001', 'product_name' => 'coca cola 1L', 'category' => 'beverages', 'available_stock' => 53, 'sold_stock' => 65, 'min_stock' => 20, 'expiry_date' => '12/11/2027', 'unit_price' => 500],
            (object) ['product_code' => '002', 'product_name' => 'Rice 50kg', 'category' => 'grains', 'available_stock' => 150, 'sold_stock' => 120, 'min_stock' => 30, 'expiry_date' => '22/07/2027', 'unit_price' => 13500],
            (object) ['product_code' => '003', 'product_name' => 'Bread Loaf', 'category' => 'bakery', 'available_stock' => 180, 'sold_stock' => 176, 'min_stock' => 4, 'expiry_date' => '29/07/2026', 'unit_price' => 150],
            (object) ['product_code' => '004', 'product_name' => 'Pick Milk', 'category' => 'beverages', 'available_stock' => 125, 'sold_stock' => 110, 'min_stock' => 15, 'expiry_date' => '12/11/2027', 'unit_price' => 400],
        ]);

        if ($request->filled('q')) {
            $q = strtolower($request->q);
            $products = $products->filter(function ($p) use ($q) {
                return str_contains(strtolower($p->product_name), $q)
                    || str_contains(strtolower($p->product_code), $q);
            })->values();
        }

        $recentSales = collect([
            (object) ['receipt_no' => '000136', 'time' => '04:08pm', 'items' => 3, 'amount' => 8350, 'payment_method' => 'cash'],
            (object) ['receipt_no' => '000135', 'time' => '03:52pm', 'items' => 6, 'amount' => 19725, 'payment_method' => 'card'],
            (object) ['receipt_no' => '000134', 'time' => '03:47pm', 'items' => 1, 'amount' => 200, 'payment_method' => 'cash'],
            (object) ['receipt_no' => '000133', 'time' => '03:41pm', 'items' => 5, 'amount' => 3600, 'payment_method' => 'mobile money'],
            (object) ['receipt_no' => '000132', 'time' => '03:36pm', 'items' => 2, 'amount' => 11000, 'payment_method' => 'card'],
            (object) ['receipt_no' => '000130', 'time' => '03:31pm', 'items' => 1, 'amount' => 1500, 'payment_method' => 'cash'],
        ]);

        if ($request->filled('payment_method') && $request->payment_method !== 'all') {
            $method = strtolower($request->payment_method);
            $recentSales = $recentSales->filter(fn ($s) => strtolower($s->payment_method) === $method)->values();
        }

        return view('admin.cashier', compact('stats', 'products', 'recentSales'));
    }
}