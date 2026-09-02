<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function inventory(Request $request)
    {
        $search = $request->input('search');

        $allProducts = Product::all();

        $allItems = $allProducts->map(function (Product $p) {
            return [
                'id' => $p->id,
                'product' => $p->name,
                'category' => $p->category,
                'quantity' => $p->stock_quantity,
                'unit' => $p->unit,
                'value' => $p->stock_quantity * $p->price,
            ];
        });

        if ($search) {
            $items = $allItems->filter(function ($item) use ($search) {
                return str_contains(strtolower($item['product']), strtolower($search)) ||
                       str_contains(strtolower($item['category'] ?? ''), strtolower($search));
            })->values();
        } else {
            $items = $allItems;
        }

        $totalValue = $allItems->sum('value');
        $totalProducts = $allItems->count();

        return view('manager.reports.inventory', compact('items', 'search', 'totalValue', 'totalProducts'));
    }

    public function lowStock(Request $request)
    {
        $search = $request->input('search');

        $allLowStock = Product::whereColumn('stock_quantity', '<=', 'low_stock_threshold')
            ->get()
            ->map(function (Product $p) {
                return [
                    'id' => $p->id,
                    'product' => $p->name,
                    'current_stock' => $p->stock_quantity,
                    'min_stock' => $p->low_stock_threshold,
                    'status' => $p->stock_quantity <= 0 ? 'Rupture de stock' : 'Stock faible',
                ];
            });

        if ($search) {
            $items = $allLowStock->filter(function ($item) use ($search) {
                return str_contains(strtolower($item['product']), strtolower($search));
            })->values();
        } else {
            $items = $allLowStock;
        }

        return view('manager.reports.low-stock', compact('items', 'search'));
    }
}