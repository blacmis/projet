<?php
namespace App\Http\Controllers\Manager;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
class CategoryController extends Controller
{
    // 1. LISTE DES CATÉGORIES
    public function index(Request $request)
    {
        $allCategories = [
            [
                'id' => 1,
                'name' => 'Grains',
                'description' => 'All grain products',
                'color' => 'primary',
            ],
            [
                'id' => 2,
                'name' => 'Groceries',
                'description' => 'General grocery items',
                'color' => 'success',
            ],
            [
                'id' => 3,
                'name' => 'Beverages',
                'description' => 'Beverages and drinks',
                'color' => 'warning',
            ],
            [
                'id' => 4,
                'name' => 'Dairy',
                'description' => 'Dairy products',
                'color' => 'info',
            ],
            [
                'id' => 5,
                'name' => 'Household',
                'description' => 'Household items',
                'color' => 'danger',
            ],
        ];
        $search = $request->input('search');
        if ($search) {
            $categories = array_filter($allCategories, function ($category) use ($search) {
                return str_contains(strtolower($category['name']), strtolower($search)) ||
                       str_contains(strtolower($category['description']), strtolower($search));
            });
        } else {
            $categories = $allCategories;
        }
        return view('manager.categories.index', compact('categories', 'search'));
    }
    // 2. FORMULAIRE D'AJOUT
    public function create()
    {
        return view('manager.categories.create');
    }
    // 3. ENREGISTRER
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
        ]);
        return redirect()->route('manager.categories.index')
                         ->with('success', 'Catégorie ajoutée avec succès (données fictives)');
    }
    // 4. FORMULAIRE DE MODIFICATION
    public function edit(int $id)
    {
        $categories = [
            1 => [
                'id' => 1,
                'name' => 'Grains',
                'description' => 'All grain products',
                'color' => 'primary',
            ],
            2 => [
                'id' => 2,
                'name' => 'Groceries',
                'description' => 'General grocery items',
                'color' => 'success',
            ],
            3 => [
                'id' => 3,
                'name' => 'Beverages',
                'description' => 'Beverages and drinks',
                'color' => 'warning',
            ],
            4 => [
                'id' => 4,
                'name' => 'Dairy',
                'description' => 'Dairy products',
                'color' => 'info',
            ],
            5 => [
                'id' => 5,
                'name' => 'Household',
                'description' => 'Household items',
                'color' => 'danger',
            ],
        ];
        if (!isset($categories[$id])) {
            return redirect()->route('manager.categories.index')
                             ->with('error', 'Catégorie introuvable');
        }
        $category = $categories[$id];
        return view('manager.categories.edit', compact('category'));
    }
    // 5. METTRE À JOUR
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
        ]);
        return redirect()->route('manager.categories.index')
                         ->with('success', 'Catégorie modifiée avec succès (données fictives)');
    }
    // 6. SUPPRIMER
    public function destroy($id)
    {
        return redirect()->route('manager.categories.index')
                         ->with('success', 'Catégorie supprimée avec succès (données fictives)');
    }
}