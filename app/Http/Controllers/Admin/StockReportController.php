<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\Concerns\HasInventoryStats;
use App\Models\Product;

class StockReportController extends Controller
{
    use HasInventoryStats;

    public function index()
    {
        $stats = $this->inventoryStats();
        $products = Product::all();

        // Résumé par catégorie
        $summary = $products->groupBy('category')->map(function ($group, $category) {
            $hasLowStock = $group->contains(fn (Product $p) => $p->status !== 'In Stock');

            return (object) [
                'category' => $category ?: 'Non catégorisé',
                'total_products' => $group->count(),
                'available_stock' => $group->sum('stock_quantity'),
                'sold_stock' => $group->sum(fn (Product $p) => $p->saleItems()->sum('quantity')),
                'stock_value_available' => $group->sum(fn (Product $p) => $p->stock_quantity * $p->price),
                'stock_value_sold' => $group->sum(fn (Product $p) => $p->saleItems()->sum('line_total')),
                'status' => $hasLowStock ? 'Low Stock' : 'In Stock',
            ];
        })->values();

        // Top 5 par stock disponible
        $topAvailable = $products->sortByDesc('stock_quantity')->take(5)->map(function (Product $p) {
            return (object) [
                'code' => sprintf('%03d', $p->id),
                'name' => $p->name,
                'category' => $p->category,
                'qty' => $p->stock_quantity,
                'unit_price' => $p->price,
                'stock_value' => $p->stock_quantity * $p->price,
            ];
        })->values();

        // Top 5 par quantité vendue (calcul séparé pour ne pas mélanger avec les objets ci-dessus)
        $topSold = $products->map(function (Product $p) {
            return (object) [
                'product' => $p,
                'sold_qty' => $p->saleItems()->sum('quantity'),
                'sold_value' => $p->saleItems()->sum('line_total'),
            ];
        })->sortByDesc('sold_qty')->take(5)->map(function ($row) {
            $p = $row->product;
            return (object) [
                'code' => sprintf('%03d', $p->id),
                'name' => $p->name,
                'category' => $p->category,
                'qty' => $row->sold_qty,
                'unit_price' => $p->price,
                'total_sales' => $row->sold_value,
            ];
        })->values();

        return view('admin.stock-report', compact('stats', 'summary', 'topAvailable', 'topSold'));
    }
}