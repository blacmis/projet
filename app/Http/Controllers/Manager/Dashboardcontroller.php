<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\StockInflow;
use App\Models\StockOutflow;
use App\Models\ExpiredDamagedGood;
use App\Models\Sale;

class DashboardController extends Controller
{
    public function index()
    {
        // Produits dont le stock est descendu au niveau ou en dessous du seuil minimum
        $lowStockCount = Product::whereColumn('stock_quantity', '<=', 'low_stock_threshold')
            ->where('stock_quantity', '>', 0)
            ->count();

        // Produits distincts ayant un lot qui expire dans les 7 prochains jours
        $expiringSoonCount = StockInflow::whereNotNull('expiry_date')
            ->whereBetween('expiry_date', [today(), today()->addDays(7)])
            ->distinct('product_id')
            ->count('product_id');

        // Produits distincts déjà marqués "expired" (table Expired & Damage Goods)
        $expiredCount = ExpiredDamagedGood::where('type', 'expired')
            ->distinct('product_id')
            ->count('product_id');

        // Total des ventes complétées aujourd'hui
        $todaysSales = Sale::where('status', 'completed')
            ->whereDate('created_at', today())
            ->sum('total');

        $recentInflows = StockInflow::with('product')
            ->orderByDesc('date_received')
            ->take(3)
            ->get();

        $recentOutflows = StockOutflow::with('product')
            ->orderByDesc('date')
            ->take(3)
            ->get();

        return view('manager.dashboard', compact(
            'lowStockCount', 'expiringSoonCount', 'expiredCount', 'todaysSales',
            'recentInflows', 'recentOutflows'
        ));
    }
}