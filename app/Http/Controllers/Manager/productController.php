<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Transforme un Product Eloquent en tableau
     * compatible avec tes vues (selling_price, quantity, ...)
     */
    private function toViewArray(Product $p): array
    {
        return [
            'id' => $p->id,
            'name' => $p->name,
            'category' => $p->category,
            'unit' => $p->unit,
            'selling_price' => $p->price,
            'quantity' => $p->stock_quantity,
            'status' => $p->status ?? 'In Stock',
        ];
    }

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

    // 1. LISTE DES PRODUITS (depuis la BDD)
    public function index(Request $request)
    {
        $query = Product::query()->orderBy('id');

        $search = $request->input('search');
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('category', 'like', "%{$search}%");
            });
        }

        $products = $query->get()->map(fn (Product $p) => $this->toViewArray($p))->all();

        return view('manager.products.index', compact('products', 'search'));
    }

    // 2. FORMULAIRE D'AJOUT
    public function create()
    {
        return view('manager.products.create');
    }

    // 3. ENREGISTRER UN NOUVEAU PRODUIT (BDD)
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string',
            'unit' => 'required|string',
            'selling_price' => 'required|numeric',
            'quantity' => 'required|integer',
        ]);

        $product = Product::create([
            'name' => $request->name,
            'category' => $request->category,
            'unit' => $request->unit,
            'price' => $request->selling_price,
            'stock_quantity' => $request->quantity,
            'low_stock_threshold' => 5,
            'is_active' => true,
            'status' => 'In Stock',
        ]);

        $this->refreshStatus($product);

        return redirect()->route('manager.products.index')
            ->with('success', 'Produit ajouté avec succès.');
    }

    // 4. FORMULAIRE DE MODIFICATION
    public function edit(int $id)
    {
        $p = Product::find($id);

        if (!$p) {
            return redirect()->route('manager.products.index')
                ->with('error', 'Produit introuvable');
        }

        $product = $this->toViewArray($p);

        return view('manager.products.edit', compact('product'));
    }

    // 5. ENREGISTRER LA MODIFICATION (BDD)
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string',
            'unit' => 'required|string',
            'selling_price' => 'required|numeric',
            'quantity' => 'required|integer',
        ]);

        $product = Product::find($id);

        if (!$product) {
            return redirect()->route('manager.products.index')
                ->with('error', 'Produit introuvable');
        }

        $product->update([
            'name' => $request->name,
            'category' => $request->category,
            'unit' => $request->unit,
            'price' => $request->selling_price,
            'stock_quantity' => $request->quantity,
        ]);

        $this->refreshStatus($product);

        return redirect()->route('manager.products.index')
            ->with('success', 'Produit modifié avec succès.');
    }

    // 6. SUPPRIMER UN PRODUIT (BDD)
    public function destroy($id)
    {
        $product = Product::find($id);

        if ($product) {
            $product->delete();
        }

        return redirect()->route('manager.products.index')
            ->with('success', 'Produit supprimé avec succès.');
    }
}