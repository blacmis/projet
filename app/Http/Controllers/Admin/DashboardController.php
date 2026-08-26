<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = (object) [
            'total_products' => 1245,
            'available_products' => 1200,
            'unavailable_products' => 45,
            'today_sales' => 96,
            'today_sales_change' => '+22% vs Yesterday',
            'today_revenue' => 4769000,
            'today_revenue_change' => '+20.6% vs Yesterday',
            'low_stock' => 24,
            'expiring_soon' => 18,
            'expired' => 7,
        ];

        return view('admin.dashboard', compact('stats'));
    }
}