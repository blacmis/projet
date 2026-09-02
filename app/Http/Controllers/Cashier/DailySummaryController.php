<?php

namespace App\Http\Controllers\Cashier;

use App\Http\Controllers\Controller;
use App\Models\Sale;
use App\Models\SaleItem;

class DailySummaryController extends Controller
{
    public function dailySummary()
    {
        $salesToday = Sale::where('status', 'completed')
            ->whereDate('created_at', today())
            ->get();

        $revenue = $salesToday->sum('total');
        $salesCount = $salesToday->count();
        $itemsSold = SaleItem::whereIn('sale_id', $salesToday->pluck('id'))->sum('quantity');
        $refunds = Sale::where('status', 'refunded')->whereDate('created_at', today())->sum('total');

        $cash = $salesToday->where('payment_method', 'cash')->sum('total');
        $mobileMoney = $salesToday->where('payment_method', 'mobile_money')->sum('total');
        $card = $salesToday->where('payment_method', 'card')->sum('total');

        $hourly = $salesToday
            ->groupBy(fn ($sale) => $sale->created_at->format('H:00'))
            ->map(fn ($group) => $group->sum('total'));

        return view('cashier.daily-summary', compact(
            'revenue', 'salesCount', 'itemsSold', 'refunds',
            'cash', 'mobileMoney', 'card', 'hourly'
        ));
    }
}