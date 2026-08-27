<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\StockAdjustment;
use Illuminate\Http\Request;

class StockAdjustmentController extends Controller
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

        $query = StockAdjustment::with('product')->orderByDesc('date');

        if ($search) {
            $query->where('reason', 'like', "%{$search}%")
                  ->orWhereHas('product', fn ($p) => $p->where('name', 'like', "%{$search}%"));
        }

        $adjustments = $query->paginate(10)->withQueryString();
        $products = Product::orderBy('name')->get();

        return view('manager.stock-adjustment.index', compact('adjustments', 'products', 'search'));
    }

    public function create()
    {
        return redirect()->route('manager.stock-adjustment.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'type'       => 'required|in:increase,decrease',
            'quantity'   => 'required|integer|min:1',
            'reason'     => 'required|string|max:255',
            'date'       => 'required|date',
        ]);

        $product = Product::findOrFail($request->product_id);

        if ($request->type === 'decrease' && $request->quantity > $product->stock_quantity) {
            return back()->withInput()
                ->with('error', 'Quantité à diminuer supérieure au stock disponible (' . $product->stock_quantity . ').');
        }

        StockAdjustment::create([
            'product_id' => $product->id,
            'type'       => $request->type,
            'quantity'   => $request->quantity,
            'reason'     => $request->reason,
            'date'       => $request->date,
        ]);

        $product->stock_quantity += $request->type === 'increase' ? $request->quantity : -$request->quantity;
        $product->save();
        $this->refreshStatus($product);

        return redirect()->route('manager.stock-adjustment.index')
            ->with('success', 'Ajustement de stock enregistré avec succès.');
    }
}