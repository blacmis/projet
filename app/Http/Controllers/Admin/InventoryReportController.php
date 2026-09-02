<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\Concerns\HasInventoryStats;
use App\Models\Product;
use Illuminate\Http\Request;

class InventoryReportController extends Controller
{
    use HasInventoryStats;

    public function index(Request $request)
    {
        $stats = $this->inventoryStats();

        $query = Product::with(['stockInflows' => fn ($q) => $q->orderByDesc('date_received')]);

        if ($request->filled('category') && $request->category !== 'all') {
            $query->where('category', $request->category);
        }

        if ($request->filled('status') && $request->status !== 'all') {
            $statusMap = [
                'In Stock' => 'In Stock',
                'Low Stock' => 'Low Stock',
                'Out-Of-Stock' => 'Out of Stock',
            ];
            $query->where('status', $statusMap[$request->status] ?? $request->status);
        }

        $products = $query->get();

        if ($request->filled('supplier') && $request->supplier !== 'all') {
            $products = $products->filter(function (Product $p) use ($request) {
                $latest = $p->stockInflows->first();
                return $latest && $latest->supplier && $latest->supplier->name === $request->supplier;
            })->values();
        }

        $items = $products->map(function (Product $p) {
            $latestInflow = $p->stockInflows->first();

            return (object) [
                'product_code' => sprintf('%03d', $p->id),
                'product_name' => $p->name,
                'category' => $p->category,
                'date' => $p->created_at->format('d/m/Y'),
                'unit_price' => $p->price,
                'total_stock' => $p->stockInflows->sum('quantity'),
                'sold_stock' => $p->saleItems()->sum('quantity'),
                'available_stock' => $p->stock_quantity,
                'status' => $p->status,
                'expiry_date' => $latestInflow?->expiry_date?->format('d/m/Y') ?? '—',
                'inventory_value' => $p->stock_quantity * $p->price,
                'supplier' => $latestInflow?->supplier?->name ?? '—',
            ];
        });

        return view('admin.inventory-report', compact('stats', 'items'));
    }
}