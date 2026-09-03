<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\ExpiredDamagedGood;
use App\Models\Product;
use App\Models\StockInflow;
use Illuminate\Http\Request;

class ExpiredController extends Controller
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

    public function index(Request $request)
    {
        $search = $request->input('search');

        $query = ExpiredDamagedGood::with('product')->orderByDesc('created_at');

        if ($search) {
            $query->whereHas('product', fn ($p) => $p->where('name', 'like', "%{$search}%"));
        }

        $records = $query->paginate(10)->withQueryString();
        $products = Product::orderBy('name')->get();

        $expiredTodayCount = ExpiredDamagedGood::where('type', 'expired')
            ->whereDate('created_at', today())->sum('quantity');

        $expiringSoonCount = StockInflow::whereNotNull('expiry_date')
            ->whereBetween('expiry_date', [today(), today()->addDays(7)])
            ->sum('quantity');

        $estimatedLoss = ExpiredDamagedGood::sum('estimated_loss');

        return view('manager.expired.index', compact(
            'records', 'products', 'search', 'expiredTodayCount', 'expiringSoonCount', 'estimatedLoss'
        ));
    }

    public function expiringSoon()
    {
        $batches = StockInflow::with('product')
            ->whereNotNull('expiry_date')
            ->whereBetween('expiry_date', [today(), today()->addDays(7)])
            ->orderBy('expiry_date')
            ->paginate(10);

        return view('manager.expired.expiring-soon', compact('batches'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id'     => 'required|exists:products,id',
            'type'           => 'required|in:expired,damaged',
            'quantity'       => 'required|integer|min:1',
            'batch_no'       => 'nullable|string|max:100',
            'expiry_date'    => 'nullable|date',
            'estimated_loss' => 'nullable|numeric|min:0',
        ]);

        $product = Product::findOrFail($request->product_id);

        if ($request->quantity > $product->stock_quantity) {
            return back()->withInput()
                ->with('error', 'Quantité supérieure au stock disponible (' . $product->stock_quantity . ').');
        }

        ExpiredDamagedGood::create([
            'product_id'     => $product->id,
            'batch_no'       => $request->batch_no,
            'type'           => $request->type,
            'quantity'       => $request->quantity,
            'expiry_date'    => $request->expiry_date,
            'estimated_loss' => $request->estimated_loss ?? ($request->quantity * $product->price),
            'status'         => 'Retiré du stock',
        ]);

        $product->stock_quantity -= $request->quantity;
        $product->save();
        $this->refreshStatus($product);

        return redirect()->route('manager.expired.index')
            ->with('success', 'Produit retiré du stock avec succès.');
    }
}