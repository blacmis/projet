<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\Concerns\HasInventoryStats;
use App\Models\StockInflow;
use Illuminate\Http\Request;

class ExpiryReportController extends Controller
{
    use HasInventoryStats;

    public function index(Request $request)
    {
        $stats = $this->inventoryStats();

        $query = StockInflow::with('product')
            ->whereNotNull('expiry_date')
            ->whereDate('expiry_date', '>=', today())
            ->orderBy('expiry_date');

        if ($request->filled('category') && $request->category !== 'all') {
            $query->whereHas('product', fn ($q) => $q->where('category', $request->category));
        }

        $items = $query->get()->map(function (StockInflow $b) {
            $daysLeft = (int) today()->diffInDays($b->expiry_date, false);
            $status = $daysLeft <= 7 ? 'Expiring Soon' : ($daysLeft <= 30 ? 'Within 30days' : null);

            if ($b->product && $b->product->stock_quantity <= 0) {
                $status = 'Out-Of-Stock';
            }

            return (object) [
                'product_code' => sprintf('%03d', $b->product_id),
                'product_name' => $b->product->name ?? '—',
                'category' => $b->product->category ?? '—',
                'batch_no' => $b->batch_no,
                'unit_price' => $b->product->price ?? 0,
                'quantity' => $b->quantity,
                'expiry_date' => $b->expiry_date->format('d/m/Y'),
                'days_left' => max($daysLeft, 0),
                'total_value' => $b->quantity * ($b->product->price ?? 0),
                'status' => $status,
            ];
        })->filter(fn ($item) => $item->status !== null)->values();

        if ($request->filled('status') && $request->status !== 'all') {
            $items = $items->filter(fn ($item) => $item->status === $request->status)->values();
        }

        return view('admin.expiry-report', compact('stats', 'items'));
    }
}