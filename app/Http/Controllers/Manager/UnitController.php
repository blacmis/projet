<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Unit;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $query = Unit::query()->orderBy('id');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('short_code', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $units = $query->get();

        return view('manager.units.index', compact('units', 'search'));
    }

    public function create()
    {
        return view('manager.units.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'short_code' => 'required|string|max:10',
            'description' => 'nullable|string|max:500',
        ]);

        Unit::create($request->only('name', 'short_code', 'description'));

        return redirect()->route('manager.units.index')
            ->with('success', 'Unité ajoutée avec succès.');
    }

    public function edit(int $id)
    {
        $unit = Unit::find($id);

        if (!$unit) {
            return redirect()->route('manager.units.index')
                ->with('error', 'Unité introuvable');
        }

        return view('manager.units.edit', compact('unit'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'short_code' => 'required|string|max:10',
            'description' => 'nullable|string|max:500',
        ]);

        $unit = Unit::find($id);

        if (!$unit) {
            return redirect()->route('manager.units.index')
                ->with('error', 'Unité introuvable');
        }

        $unit->update($request->only('name', 'short_code', 'description'));

        return redirect()->route('manager.units.index')
            ->with('success', 'Unité modifiée avec succès.');
    }

    public function destroy($id)
    {
        $unit = Unit::find($id);

        if ($unit) {
            $unit->delete();
        }

        return redirect()->route('manager.units.index')
            ->with('success', 'Unité supprimée avec succès.');
    }
}