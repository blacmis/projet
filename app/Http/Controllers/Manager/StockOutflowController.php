<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\StockOutflow;
use Illuminate\Http\Request;

class StockOutflowController extends Controller
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

        $query = StockOutflow::with('product')->orderByDesc('date');

        if ($search) {
            $query->where('type', 'like', "%{$search}%")
                  ->orWhereHas('product', fn ($p) => $p->where('name', 'like', "%{$search}%"));
        }

        $outflows = $query->paginate(10)->withQueryString();
        $products = Product::orderBy('name')->get();

        return view('manager.stock-outflow.index', compact('outflows', 'products', 'search'));
    }

    public function create()
    {
        return redirect()->route('manager.stock-outflow.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'type'       => 'required|string',
            'quantity'   => 'required|integer|min:1',
            'unit_cost'  => 'required|numeric|min:0',
            'date'       => 'required|date',
            'reason'     => 'nullable|string|max:255',
        ]);

        $product = Product::findOrFail($request->product_id);

        if ($request->quantity > $product->stock_quantity) {
            return back()->withInput()
                ->with('error', 'Quantité supérieure au stock disponible (' . $product->stock_quantity . ').');
        }

        StockOutflow::create([
            'product_id'  => $product->id,
            'type'        => $request->type,
            'quantity'    => $request->quantity,
            'unit_cost'   => $request->unit_cost,
            'total_value' => $request->quantity * $request->unit_cost,
            'date'        => $request->date,
            'reason'      => $request->reason,
        ]);

        $product->stock_quantity -= $request->quantity;
        $product->save();
        $this->refreshStatus($product);

        return redirect()->route('manager.stock-outflow.index')
            ->with('success', 'Sortie de stock enregistrée avec succès.');
    }
}