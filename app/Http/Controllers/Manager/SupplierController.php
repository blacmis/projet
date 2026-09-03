<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $query = Supplier::query()->orderBy('id');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $suppliers = $query->get();

        return view('manager.suppliers.index', compact('suppliers', 'search'));
    }

    public function create()
    {
        return view('manager.suppliers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
        ]);

        Supplier::create($request->only('name', 'phone', 'email'));

        return redirect()->route('manager.suppliers.index')
            ->with('success', 'Fournisseur ajouté avec succès.');
    }

    public function edit(int $id)
    {
        $supplier = Supplier::find($id);

        if (!$supplier) {
            return redirect()->route('manager.suppliers.index')
                ->with('error', 'Fournisseur introuvable');
        }

        return view('manager.suppliers.edit', compact('supplier'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
        ]);

        $supplier = Supplier::find($id);

        if (!$supplier) {
            return redirect()->route('manager.suppliers.index')
                ->with('error', 'Fournisseur introuvable');
        }

        $supplier->update($request->only('name', 'phone', 'email'));

        return redirect()->route('manager.suppliers.index')
            ->with('success', 'Fournisseur modifié avec succès.');
    }

    public function destroy($id)
    {
        $supplier = Supplier::find($id);

        if ($supplier) {
            $supplier->delete();
        }

        return redirect()->route('manager.suppliers.index')
            ->with('success', 'Fournisseur supprimé avec succès.');
    }
}