<?php
namespace App\Http\Controllers\Manager;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
class ProductController extends Controller
{
    // 1. LISTE DES PRODUITS
     public function index(Request $request)
{
    $allProducts = [
        [
            'id' => 1,
            'name' => 'Rice 5kg',
            'category' => 'Grains',
            'unit' => 'Bag',
            'selling_price' => 2500,
            'quantity' => 150,
            'status' => 'In Stock',
        ],
        [
            'id' => 2,
            'name' => 'Cooking Oil 2L',
            'category' => 'Beverage',
            'unit' => 'Piece',
            'selling_price' => 3500,
            'quantity' => 80,
            'status' => 'In Stock',
        ],
        [
            'id' => 3,
            'name' => 'Sugar 5kg',
            'category' => 'Groceries',
            'unit' => 'Bag',
            'selling_price' => 2200,
            'quantity' => 60,
            'status' => 'In Stock',
        ],
        [
            'id' => 4,
            'name' => 'Milk 1L',
            'category' => 'Dairy',
            'unit' => 'Piece',
            'selling_price' => 500,
            'quantity' => 120,
            'status' => 'In Stock',
        ],
        [
            'id' => 5,
            'name' => 'White Flour 25kg',
            'category' => 'Groceries',
            'unit' => 'Bag',
            'selling_price' => 1000,
            'quantity' => 40,
            'status' => 'Low Stock',
        ],
    ];
    // Recherche
    $search = $request->input('search');
    if ($search) {
        $products = array_filter($allProducts, function ($product) use ($search) {
            return str_contains(strtolower($product['name']), strtolower($search)) ||
                   str_contains(strtolower($product['category']), strtolower($search));
        });
    } else {
        $products = $allProducts;
    }
    return view('manager.products.index', compact('products', 'search'));
}
    // 2. FORMULAIRE D'AJOUT
    public function create()
    {
        return view('manager.products.create');
    }
    // 3. ENREGISTRER UN NOUVEAU PRODUIT
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string',
            'unit' => 'required|string',
            'selling_price' => 'required|numeric',
            'quantity' => 'required|integer',
        ]);
        // Pour l'instant on simule seulement (données fictives)
        return redirect()->route('manager.products.index')
                         ->with('success', 'Produit ajouté avec succès (données fictives)');
    }
    // 4. FORMULAIRE DE MODIFICATION
    public function edit(int $id)
    {
        $products = [
            1 => [
                'id' => 1,
                'name' => 'Rice 5kg',
                'category' => 'Grains',
                'unit' => 'Bag',
                'selling_price' => 2500,
                'quantity' => 150,
                'status' => 'In Stock',
            ],
            2 => [
                'id' => 2,
                'name' => 'Cooking Oil 2L',
                'category' => 'Beverage',
                'unit' => 'Piece',
                'selling_price' => 3500,
                'quantity' => 80,
                'status' => 'In Stock',
            ],
            3 => [
                'id' => 3,
                'name' => 'Sugar 5kg',
                'category' => 'Groceries',
                'unit' => 'Bag',
                'selling_price' => 2200,
                'quantity' => 60,
                'status' => 'In Stock',
            ],
            4 => [
                'id' => 4,
                'name' => 'Milk 1L',
                'category' => 'Dairy',
                'unit' => 'Piece',
                'selling_price' => 500,
                'quantity' => 120,
                'status' => 'In Stock',
            ],
            5 => [
                'id' => 5,
                'name' => 'White Flour 25kg',
                'category' => 'Groceries',
                'unit' => 'Bag',
                'selling_price' => 1000,
                'quantity' => 40,
                'status' => 'Low Stock',
            ],
        ];
        if (!isset($products[$id])) {
            return redirect()->route('manager.products.index')
                             ->with('error', 'Produit introuvable');
        }
        $product = $products[$id];
        return view('manager.products.edit', compact('product'));
    }
    // 5. ENREGISTRER LA MODIFICATION
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string',
            'unit' => 'required|string',
            'selling_price' => 'required|numeric',
            'quantity' => 'required|integer',
        ]);
        // Pour l'instant on simule seulement
        return redirect()->route('manager.products.index')
                         ->with('success', 'Produit modifié avec succès (données fictives)');
    }
    // 6. SUPPRIMER UN PRODUIT
    public function destroy($id)
    {
        // Pour l'instant on simule seulement
        return redirect()->route('manager.products.index')
                         ->with('success', 'Produit supprimé avec succès (données fictives)');
    }
}