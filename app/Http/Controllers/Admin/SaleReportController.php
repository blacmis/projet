<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sale;
use App\Models\SaleItem;
use Illuminate\Http\Request;

class SaleReportController extends Controller
{
    public function index(Request $request)
    {
        $monthSales = Sale::whereMonth('created_at', now()->month)->whereYear('created_at', now()->year);

        $stats = (object) [
            'total_sales' => (clone $monthSales)->where('status', 'completed')->count(),
            'total_revenue' => (clone $monthSales)->where('status', 'completed')->sum('total'),
            'total_transactions' => (clone $monthSales)->count(),
            'items_sold' => SaleItem::whereIn('sale_id', (clone $monthSales)->pluck('id'))->sum('quantity'),
        ];

        $query = Sale::orderByDesc('created_at');

        if ($request->filled('payment_method') && $request->payment_method !== 'all') {
            $method = strtolower(str_replace(' ', '_', $request->payment_method));
            $query->where('payment_method', $method);
        }

        $sales = $query->take(50)->get()->map(function (Sale $s) {
            return (object) [
                'date_time' => $s->created_at->format('d/m/Y H:i'),
                'receipt_no' => $s->transaction_number,
                'items' => $s->items()->sum('quantity'),
                'amount' => $s->total,
                'payment_method' => ucwords(str_replace('_', ' ', $s->payment_method)),
            ];
        });

        return view('admin.sale-report', compact('stats', 'sales'));
    }
}