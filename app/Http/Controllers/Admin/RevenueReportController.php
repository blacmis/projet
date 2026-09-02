<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sale;
use Illuminate\Http\Request;

class RevenueReportController extends Controller
{
    public function index(Request $request)
    {
        $completed = Sale::where('status', 'completed');

        $todayRevenue = (clone $completed)->whereDate('created_at', today())->sum('total');
        $weekRevenue = (clone $completed)->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->sum('total');
        $monthRevenue = (clone $completed)->whereMonth('created_at', now()->month)->whereYear('created_at', now()->year)->sum('total');
        $yearRevenue = (clone $completed)->whereYear('created_at', now()->year)->sum('total');

        $daysElapsed = max(now()->day, 1);
        $averageDaily = $monthRevenue / $daysElapsed;

        $monthDiscount = (clone $completed)->whereMonth('created_at', now()->month)->whereYear('created_at', now()->year)->sum('discount');

        // ⚠️ Approximation : products n'a pas de cost_price, donc pas de vraie marge (vente - coût).
        // On approxime le profit brut par (revenu - remises accordées).
        $grossProfit = $monthRevenue - $monthDiscount;

        $totalTransactions = (clone $completed)->whereMonth('created_at', now()->month)->whereYear('created_at', now()->year)->count();

        $stats = (object) [
            'total_revenue' => $monthRevenue,
            'today_revenue' => $todayRevenue,
            'today_date' => today()->format('d/m/Y'),
            'week_revenue' => $weekRevenue,
            'month_revenue' => $monthRevenue,
            'year_revenue' => $yearRevenue,
            'average_daily' => $averageDaily,
            'gross_profit' => $grossProfit,
            'total_transactions' => $totalTransactions,
        ];

        $query = Sale::orderByDesc('created_at');

        if ($request->filled('payment_method') && $request->payment_method !== 'all') {
            $method = strtolower(str_replace(' ', '_', $request->payment_method));
            $query->where('payment_method', $method);
        }

        $transactions = $query->take(50)->get()->map(function (Sale $s) {
            return (object) [
                'date_time' => $s->created_at->format('d/m/Y H:i'),
                'receipt_no' => $s->transaction_number,
                'amount' => $s->total,
                'payment_method' => ucwords(str_replace('_', ' ', $s->payment_method)),
                'status' => ucfirst($s->status),
            ];
        });

        return view('admin.revenue-report', compact('stats', 'transactions'));
    }
}