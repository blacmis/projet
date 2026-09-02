<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class InventoryActionController extends Controller
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

    private function toArray(Product $p): array
    {
        return [
            'id' => $p->id,
            'code' => str_pad((string) $p->id, 5, '0', STR_PAD_LEFT),
            'name' => $p->name,
            'category' => $p->category,
            'stock' => $p->stock_quantity,
            'min_stock' => $p->low_stock_threshold,
            'status' => $p->status,
        ];
    }

    public function index(Request $request)
    {
        $query = Product::query();

        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($sub) use ($q) {
                $sub->where('name', 'like', "%{$q}%")
                    ->orWhere('id', 'like', "%{$q}%");
            });
        }

        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        $products = $query->orderBy('id')->get()->map(fn (Product $p) => $this->toArray($p));

        return view('admin.inventory-actions.index', compact('products'));
    }

    public function adjust(Request $request, $id)
    {
        $request->validate([
            'type' => 'required|in:add,remove,set',
            'quantity' => 'required|integer|min:0',
        ]);

        $product = Product::find($id);

        if (!$product) {
            return back()->with('error', 'Produit introuvable.');
        }

        if ($request->type === 'add') {
            $product->stock_quantity += (int) $request->quantity;
        } elseif ($request->type === 'remove') {
            $product->stock_quantity = max(0, $product->stock_quantity - (int) $request->quantity);
        } else {
            $product->stock_quantity = (int) $request->quantity;
        }

        $product->save();
        $this->refreshStatus($product);

        AuditLogController::log(
            'STOCK_ADJUST',
            "Product ID {$id} type={$request->type} qty={$request->quantity}"
        );

        return back()->with('success', 'Stock mis à jour par l\'administrateur.');
    }

    public function setStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:In Stock,Low Stock,Out of Stock,Unavailable',
        ]);

        $product = Product::find($id);

        if (!$product) {
            return back()->with('error', 'Produit introuvable.');
        }

        $product->status = $request->status;
        $product->save();

        AuditLogController::log('STOCK_STATUS', "Product ID {$id} status={$request->status}");

        return back()->with('success', 'Statut produit mis à jour.');
    }
}