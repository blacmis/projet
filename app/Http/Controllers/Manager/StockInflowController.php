<?php
namespace App\Http\Controllers\Manager;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
class StockInflowController extends Controller
{
    public function index(Request $request)
    {
        $allInflows = [
            [
                'id' => 1,
                'date' => '08/05/2026',
                'product' => 'Rice 50kg',
                'quantity' => 100,
                'unit_cost' => 2000,
                'total_value' => 200000,
                'supplier' => 'ABC Suppliers',
            ],
            [
                'id' => 2,
                'date' => '08/05/2026',
                'product' => 'Cooking Oil 20L',
                'quantity' => 50,
                'unit_cost' => 3000,
                'total_value' => 150000,
                'supplier' => 'GoodFoods Ltd',
            ],
            [
                'id' => 3,
                'date' => '07/05/2026',
                'product' => 'Sugar 50kg',
                'quantity' => 80,
                'unit_cost' => 2200,
                'total_value' => 176000,
                'supplier' => 'Sweet Supply',
            ],
            [
                'id' => 4,
                'date' => '06/05/2026',
                'product' => 'Milk 1L',
                'quantity' => 200,
                'unit_cost' => 450,
                'total_value' => 90000,
                'supplier' => 'Dairy Farm',
            ],
            [
                'id' => 5,
                'date' => '05/05/2026',
                'product' => 'White Flour 25kg',
                'quantity' => 40,
                'unit_cost' => 2500,
                'total_value' => 100000,
                'supplier' => 'Millers Ltd',
            ],
        ];
        $search = $request->input('search');
        if ($search) {
            $inflows = array_filter($allInflows, function ($item) use ($search) {
                return str_contains(strtolower($item['product']), strtolower($search)) ||
                       str_contains(strtolower($item['supplier']), strtolower($search));
            });
        } else {
            $inflows = $allInflows;
        }
        return view('manager.stock-inflow.index', compact('inflows', 'search'));
    }
    public function create()
    {
        // Listes fictives pour les selects
        $products = [
            'Rice 50kg',
            'Cooking Oil 20L',
            'Sugar 50kg',
            'Milk 1L',
            'White Flour 25kg',
        ];
        $suppliers = [
            'ABC Suppliers',
            'GoodFoods Ltd',
            'Sweet Supply',
            'Dairy Farm',
            'Millers Ltd',
        ];
        return view('manager.stock-inflow.create', compact('products', 'suppliers'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'product' => 'required|string',
            'quantity' => 'required|integer|min:1',
            'unit_cost' => 'required|numeric|min:0',
            'supplier' => 'required|string',
            'date' => 'required|date',
        ]);
        return redirect()->route('manager.stock-inflow.index')
                         ->with('success', 'Entrée de stock enregistrée avec succès (données fictives)');
    }
}