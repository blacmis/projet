<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Sale;
use Illuminate\Http\Request;

class CashierOverviewController extends Controller
{
    public function index(Request $request)
    {
        $stats = $this->buildStats();

        $products = $this->buildProducts($request->input('q'));

        $recentSales = $this->buildRecentSales($request->input('payment_method'));

        return view('admin.cashier', compact('stats', 'products', 'recentSales'));
    }

    private function buildStats(): object
    {
        $todayItemsSold = \App\Models\SaleItem::whereHas('sale', function ($q) {
            $q->where('status', 'completed')->whereDate('created_at', today());
        })->sum('quantity');

        $yesterdayItemsSold = \App\Models\SaleItem::whereHas('sale', function ($q) {
            $q->where('status', 'completed')->whereDate('created_at', today()->subDay());
        })->sum('quantity');

        $todayRevenue = Sale::where('status', 'completed')->whereDate('created_at', today())->sum('total');
        $yesterdayRevenue = Sale::where('status', 'completed')->whereDate('created_at', today()->subDay())->sum('total');

        $todayTransactions = Sale::where('status', 'completed')->whereDate('created_at', today())->count();

        return (object) [
            'today_sales' => $todayItemsSold,
            'today_sales_change' => $this->percentChange($todayItemsSold, $yesterdayItemsSold) . ' vs Yesterday',
            'today_revenue' => $todayRevenue,
            'today_revenue_change' => $this->percentChange($todayRevenue, $yesterdayRevenue) . ' vs Yesterday',
            'transactions' => $todayTransactions,
        ];
    }

    private function buildProducts(?string $q)
    {
        $query = Product::query()->orderBy('id');

        if ($q) {
            $q = strtolower($q);
            $query->where(function ($query) use ($q) {
                $query->whereRaw('LOWER(name) LIKE ?', ["%{$q}%"])
                    ->orWhereRaw('LOWER(barcode) LIKE ?', ["%{$q}%"]);
            });
        }

        return $query->get()->map(function (Product $p) {
            $latestInflow = $p->stockInflows()->whereNotNull('expiry_date')->latest('expiry_date')->first();
            $soldStock = $p->saleItems()->sum('quantity');

            return (object) [
                'product_code' => $p->barcode ?: str_pad((string) $p->id, 3, '0', STR_PAD_LEFT),
                'product_name' => $p->name,
                'category' => $p->category ?? '—',
                'available_stock' => $p->stock_quantity,
                'sold_stock' => $soldStock,
                'min_stock' => $p->low_stock_threshold,
                'expiry_date' => $latestInflow?->expiry_date?->format('d/m/Y') ?? '—',
                'unit_price' => $p->price,
            ];
        });
    }

    private function buildRecentSales(?string $paymentMethod)
    {
        $query = Sale::where('status', 'completed')->with('items')->latest();

        if ($paymentMethod && $paymentMethod !== 'all') {
            $query->where('payment_method', $paymentMethod);
        }

        return $query->take(6)->get()->map(function (Sale $sale) {
            return (object) [
                'receipt_no' => $sale->transaction_number,
                'time' => $sale->created_at->format('h:ia'),
                'items' => $sale->items->sum('quantity'),
                'amount' => $sale->total,
                'payment_method' => $sale->payment_method,
            ];
        });
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