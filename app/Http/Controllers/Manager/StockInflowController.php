<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Product;
use App\Models\StockInflow;
use App\Models\Supplier;
use Illuminate\Http\Request;

class StockInflowController extends Controller
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

        $query = StockInflow::with(['product', 'supplier'])->orderByDesc('date_received');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->whereHas('product', fn ($p) => $p->where('name', 'like', "%{$search}%"))
                  ->orWhereHas('supplier', fn ($s) => $s->where('name', 'like', "%{$search}%"));
            });
        }

        $inflows = $query->paginate(10)->withQueryString();

        $products = Product::orderBy('name')->get();
        $suppliers = Supplier::orderBy('name')->get();

        $todayCount = StockInflow::whereDate('date_received', today())->count();
        $todayValue = StockInflow::whereDate('date_received', today())->sum('total_value');
        $activeSuppliers = Supplier::count();

        return view('manager.stock-inflow.index', compact(
            'inflows', 'products', 'suppliers', 'search', 'todayCount', 'todayValue', 'activeSuppliers'
        ));
    }

    public function create()
    {
        return redirect()->route('manager.stock-inflow.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id'    => 'required|exists:products,id',
            'supplier_id'   => 'nullable|exists:suppliers,id',
            'quantity'      => 'required|integer|min:1',
            'unit_cost'     => 'required|numeric|min:0',
            'date_received' => 'required|date',
            'expiry_date'   => 'nullable|date',
            'batch_no'      => 'nullable|string|max:100',
        ]);

        $product = Product::findOrFail($request->product_id);

        StockInflow::create([
            'product_id'    => $product->id,
            'supplier_id'   => $request->supplier_id,
            'batch_no'      => $request->batch_no ?: 'BATCH-' . strtoupper(uniqid()),
            'quantity'      => $request->quantity,
            'unit_cost'     => $request->unit_cost,
            'total_value'   => $request->quantity * $request->unit_cost,
            'date_received' => $request->date_received,
            'expiry_date'   => $request->expiry_date,
        ]);

        $product->stock_quantity += $request->quantity;
        $product->save();
        $this->refreshStatus($product);

        ActivityLog::record(
            'stock',
            'Stock Received',
            "{$request->quantity} units of {$product->name} received",
            'STK-REC-' . now()->format('YmdHis')
        );

        return redirect()->route('manager.stock-inflow.index')
            ->with('success', 'Entrée de stock enregistrée avec succès.');
    }
}