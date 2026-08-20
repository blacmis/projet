<?php
namespace App\Http\Controllers\Manager;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
class UnitController extends Controller
{
    public function index(Request $request)
    {
        $allUnits = [
            [
                'id' => 1,
                'name' => 'Piece',
                'short_code' => 'PC',
                'description' => 'Single piece',
            ],
            [
                'id' => 2,
                'name' => 'Kilogram',
                'short_code' => 'KG',
                'description' => 'Weight in kilograms',
            ],
            [
                'id' => 3,
                'name' => 'Litre',
                'short_code' => 'LT',
                'description' => 'Liquid in litres',
            ],
            [
                'id' => 4,
                'name' => 'Bag',
                'short_code' => 'BAG',
                'description' => 'Bag or sack',
            ],
            [
                'id' => 5,
                'name' => 'Carton',
                'short_code' => 'CTN',
                'description' => 'Carton pack',
            ],
        ];
        $search = $request->input('search');
        if ($search) {
            $units = array_filter($allUnits, function ($unit) use ($search) {
                return str_contains(strtolower($unit['name']), strtolower($search)) ||
                       str_contains(strtolower($unit['short_code']), strtolower($search)) ||
                       str_contains(strtolower($unit['description']), strtolower($search));
            });
        } else {
            $units = $allUnits;
        }
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
        return redirect()->route('manager.units.index')
                         ->with('success', 'Unité ajoutée avec succès (données fictives)');
    }
    public function edit(int $id)
    {
        $units = [
            1 => [
                'id' => 1,
                'name' => 'Piece',
                'short_code' => 'PC',
                'description' => 'Single piece',
            ],
            2 => [
                'id' => 2,
                'name' => 'Kilogram',
                'short_code' => 'KG',
                'description' => 'Weight in kilograms',
            ],
            3 => [
                'id' => 3,
                'name' => 'Litre',
                'short_code' => 'LT',
                'description' => 'Liquid in litres',
            ],
            4 => [
                'id' => 4,
                'name' => 'Bag',
                'short_code' => 'BAG',
                'description' => 'Bag or sack',
            ],
            5 => [
                'id' => 5,
                'name' => 'Carton',
                'short_code' => 'CTN',
                'description' => 'Carton pack',
            ],
        ];
        if (!isset($units[$id])) {
            return redirect()->route('manager.units.index')
                             ->with('error', 'Unité introuvable');
        }
        $unit = $units[$id];
        return view('manager.units.edit', compact('unit'));
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'short_code' => 'required|string|max:10',
            'description' => 'nullable|string|max:500',
        ]);
        return redirect()->route('manager.units.index')
                         ->with('success', 'Unité modifiée avec succès (données fictives)');
    }
    public function destroy($id)
    {
        return redirect()->route('manager.units.index')
                         ->with('success', 'Unité supprimée avec succès (données fictives)');
    }
}