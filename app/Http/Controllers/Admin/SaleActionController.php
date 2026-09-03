<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Sale;
use Illuminate\Http\Request;

class SaleActionController extends Controller
{
    private function refreshStatus(Product $product): void
    {
        if ($product->stock_quantity <= 0) {
            $product->status = 'Out of Stock';
        } elseif ($product->stock_quantity <= ($product->low_stock_threshold ?? 5)) {
            $product->status = 'Low Stock';
        } else {
            $product->status = 'In Stock';
        }
        $product->save();
    }

    private function toArray(Sale $s): array
    {
        return [
            'id' => $s->id,
            'receipt_no' => $s->transaction_number,
            'date_time' => $s->created_at->format('d-m-Y h:iA'),
            'cashier' => $s->cashier_name,
            'amount' => $s->total,
            'payment_method' => ucwords(str_replace('_', ' ', $s->payment_method)),
            'items' => $s->items()->sum('quantity'),
            'status' => ucfirst($s->status),
        ];
    }

    public function index(Request $request)
    {
        $query = Sale::query();

        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($sub) use ($q) {
                $sub->where('transaction_number', 'like', "%{$q}%")
                    ->orWhere('cashier_name', 'like', "%{$q}%")
                    ->orWhere('payment_method', 'like', "%{$q}%");
            });
        }

        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', strtolower($request->status));
        }

        if ($request->filled('payment') && $request->payment !== 'all') {
            $method = strtolower(str_replace(' ', '_', $request->payment));
            $query->where('payment_method', $method);
        }

        $sales = $query->orderByDesc('created_at')->get()->map(fn (Sale $s) => $this->toArray($s));

        $stats = (object) [
            'total' => Sale::count(),
            'completed' => Sale::where('status', 'completed')->count(),
            'cancelled' => Sale::where('status', 'cancelled')->count(),
            'revenue' => Sale::where('status', 'completed')->sum('total'),
        ];

        return view('admin.sale-actions.index', compact('sales', 'stats'));
    }

    public function cancel($id)
    {
        $sale = Sale::with('items')->find($id);

        if (!$sale) {
            return back()->with('error', 'Vente introuvable.');
        }

        if ($sale->status === 'cancelled') {
            return back()->with('error', 'Cette vente est déjà annulée.');
        }

        // Réintègre le stock des produits vendus
        foreach ($sale->items as $item) {
            $product = Product::find($item->product_id);
            if ($product) {
                $product->stock_quantity += $item->quantity;
                $product->save();
                $this->refreshStatus($product);
            }
        }

        $sale->status = 'cancelled';
        $sale->save();

        AuditLogController::log('SALE_CANCEL', "Sale ID {$id} cancelled — stock restored");

        return back()->with('success', 'Vente annulée, stock réintégré.');
    }

    public function restore($id)
    {
        $sale = Sale::with('items')->find($id);

        if (!$sale) {
            return back()->with('error', 'Vente introuvable.');
        }

        if ($sale->status !== 'cancelled') {
            return back()->with('error', 'Cette vente n\'est pas annulée.');
        }

        // Vérifie qu'il y a assez de stock pour re-déduire
        foreach ($sale->items as $item) {
            $product = Product::find($item->product_id);
            if (!$product || $product->stock_quantity < $item->quantity) {
                return back()->with('error', "Stock insuffisant pour restaurer cette vente ({$item->product_name}).");
            }
        }

        foreach ($sale->items as $item) {
            $product = Product::find($item->product_id);
            $product->stock_quantity -= $item->quantity;
            $product->save();
            $this->refreshStatus($product);
        }

        $sale->status = 'completed';
        $sale->save();

        AuditLogController::log('SALE_RESTORE', "Sale ID {$id} restored — stock re-deducted");

        return back()->with('success', 'Vente restaurée (Completed), stock re-déduit.');
    }
}