<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RevenueReportController extends Controller
{
    public function index(Request $request)
    {
        $stats = (object) [
            'total_revenue' => 245780,
            'today_revenue' => 8192,
            'today_date' => '2026-08-07',
            'week_revenue' => 56345,
            'month_revenue' => 245780,
            'year_revenue' => 2456780,
            'average_daily' => 8192,
            'gross_profit' => 98650,
            'total_transactions' => 1156,
        ];

        $transactions = collect([
            (object) ['date_time' => '30-07-2026 12:00PM', 'receipt_no' => 'RCPT-0048025', 'amount' => 11250, 'payment_method' => 'Card', 'status' => 'Sales Completed'],
            (object) ['date_time' => '30-07-2026 12:02PM', 'receipt_no' => 'RCPT-0048024', 'amount' => 15000, 'payment_method' => 'Cash', 'status' => 'Sales Completed'],
            (object) ['date_time' => '30-07-2026 12:05PM', 'receipt_no' => 'RCPT-0048023', 'amount' => 3255, 'payment_method' => 'Cash', 'status' => 'Sales Completed'],
            (object) ['date_time' => '30-07-2026 12:10PM', 'receipt_no' => 'RCPT-0048022', 'amount' => 5200, 'payment_method' => 'Mobile Money', 'status' => 'Sales Completed'],
            (object) ['date_time' => '30-07-2026 12:15PM', 'receipt_no' => 'RCPT-0048021', 'amount' => 715, 'payment_method' => 'Cash', 'status' => 'Sales Completed'],
        ]);

        if ($request->filled('payment_method') && $request->payment_method !== 'all') {
            $transactions = $transactions->filter(fn ($t) => strtolower($t->payment_method) === strtolower($request->payment_method))->values();
        }

        return view('admin.revenue-report', compact('stats', 'transactions'));
    }
}