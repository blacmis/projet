<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\Concerns\HasInventoryStats;
use App\Models\Sale;

class DashboardController extends Controller
{
    use HasInventoryStats;

    public function index()
    {
        $base = $this->inventoryStats();

        $todaySalesCount = Sale::where('status', 'completed')->whereDate('created_at', today())->count();
        $yesterdaySalesCount = Sale::where('status', 'completed')->whereDate('created_at', today()->subDay())->count();

        $todayRevenue = Sale::where('status', 'completed')->whereDate('created_at', today())->sum('total');
        $yesterdayRevenue = Sale::where('status', 'completed')->whereDate('created_at', today()->subDay())->sum('total');

        $stats = (object) array_merge((array) $base, [
            'today_sales' => $todaySalesCount,
            'today_sales_change' => $this->percentChange($todaySalesCount, $yesterdaySalesCount) . ' vs Yesterday',
            'today_revenue' => $todayRevenue,
            'today_revenue_change' => $this->percentChange($todayRevenue, $yesterdayRevenue) . ' vs Yesterday',
        ]);

        return view('admin.dashboard', compact('stats'));
    }

    private function percentChange($today, $yesterday): string
    {
        if ($yesterday <= 0) {
            return $today > 0 ? '+100%' : '0%';
        }
        $change = round((($today - $yesterday) / $yesterday) * 100);
        return ($change >= 0 ? '+' : '') . $change . '%';
    }
}