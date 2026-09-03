<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    // Palette utilisée pour assigner automatiquement une couleur à la création
    private array $colors = ['primary', 'success', 'warning', 'info', 'danger'];

    // 1. LISTE DES CATÉGORIES
    public function index(Request $request)
    {
        $search = $request->input('search');

        $query = Category::query()->orderBy('id');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $categories = $query->get();

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

        $nextColor = $this->colors[Category::count() % count($this->colors)];

        Category::create([
            'name' => $request->name,
            'description' => $request->description,
            'color' => $nextColor,
        ]);

        return redirect()->route('manager.categories.index')
            ->with('success', 'Catégorie ajoutée avec succès.');
    }

    // 4. FORMULAIRE DE MODIFICATION
    public function edit(int $id)
    {
        $category = Category::find($id);

        if (!$category) {
            return redirect()->route('manager.categories.index')
                ->with('error', 'Catégorie introuvable');
        }

        return view('manager.categories.edit', compact('category'));
    }

    // 5. METTRE À JOUR
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
        ]);

        $category = Category::find($id);

        if (!$category) {
            return redirect()->route('manager.categories.index')
                ->with('error', 'Catégorie introuvable');
        }

        $category->update($request->only('name', 'description'));
        // la couleur n'est pas touchée à la modification

        return redirect()->route('manager.categories.index')
            ->with('success', 'Catégorie modifiée avec succès.');
    }

    // 6. SUPPRIMER
    public function destroy($id)
    {
        $category = Category::find($id);

        if ($category) {
            $category->delete();
        }

        return redirect()->route('manager.categories.index')
            ->with('success', 'Catégorie supprimée avec succès.');
    }
}