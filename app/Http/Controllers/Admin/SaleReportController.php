<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SaleReportController extends Controller
{
    public function index(Request $request)
    {
        $stats = (object) [
            'total_sales' => 1245,
            'total_revenue' => 6854000,
            'total_transactions' => 1156,
            'items_sold' => 3845,
        ];

        $sales = collect([
            (object) ['date_time' => '30-07-2026 12:00PM', 'receipt_no' => 'RCPT-0048025', 'items' => 4, 'amount' => 11250, 'payment_method' => 'Card'],
            (object) ['date_time' => '30-07-2026 12:02PM', 'receipt_no' => 'RCPT-0048024', 'items' => 6, 'amount' => 15000, 'payment_method' => 'Cash'],
            (object) ['date_time' => '30-07-2026 12:05PM', 'receipt_no' => 'RCPT-0048023', 'items' => 2, 'amount' => 3255, 'payment_method' => 'Cash'],
            (object) ['date_time' => '30-07-2026 12:10PM', 'receipt_no' => 'RCPT-0048022', 'items' => 4, 'amount' => 5200, 'payment_method' => 'Mobile Money'],
            (object) ['date_time' => '30-07-2026 12:15PM', 'receipt_no' => 'RCPT-0048021', 'items' => 3, 'amount' => 715, 'payment_method' => 'Cash'],
        ]);

        if ($request->filled('payment_method') && $request->payment_method !== 'all') {
            $sales = $sales->filter(fn ($s) => strtolower($s->payment_method) === strtolower($request->payment_method))->values();
        }

        return view('admin.sale-report', compact('stats', 'sales'));
    }
}