<?php
namespace App\Http\Controllers\Manager;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
class StockOutflowController extends Controller
{
    public function index(Request $request)
    {
        $allOutflows = [
            [
                'id' => 1,
                'date' => '08/05/2026',
                'product' => 'Rice 50kg',
                'quantity' => 20,
                'type' => 'Sale',
                'unit_cost' => 2500,
                'total_value' => 50000,
            ],
            [
                'id' => 2,
                'date' => '08/05/2026',
                'product' => 'Cooking Oil 20L',
                'quantity' => 10,
                'type' => 'Sale',
                'unit_cost' => 3500,
                'total_value' => 35000,
            ],
            [
                'id' => 3,
                'date' => '07/05/2026',
                'product' => 'Sugar 50kg',
                'quantity' => 5,
                'type' => 'Damage',
                'unit_cost' => 2200,
                'total_value' => 11000,
            ],
            [
                'id' => 4,
                'date' => '06/05/2026',
                'product' => 'Milk 1L',
                'quantity' => 30,
                'type' => 'Sale',
                'unit_cost' => 500,
                'total_value' => 15000,
            ],
            [
                'id' => 5,
                'date' => '05/05/2026',
                'product' => 'White Flour 25kg',
                'quantity' => 8,
                'type' => 'Expired',
                'unit_cost' => 1000,
                'total_value' => 8000,
            ],
        ];
        $search = $request->input('search');
        if ($search) {
            $outflows = array_filter($allOutflows, function ($item) use ($search) {
                return str_contains(strtolower($item['product']), strtolower($search)) ||
                       str_contains(strtolower($item['type']), strtolower($search));
            });
        } else {
            $outflows = $allOutflows;
        }
        return view('manager.stock-outflow.index', compact('outflows', 'search'));
    }
    public function create()
    {
        $products = [
            'Rice 50kg',
            'Cooking Oil 20L',
            'Sugar 50kg',
            'Milk 1L',
            'White Flour 25kg',
        ];
        $types = [
            'Sale',
            'Damage',
            'Expired',
            'Transfer',
            'Other',
        ];
        return view('manager.stock-outflow.create', compact('products', 'types'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'product' => 'required|string',
            'quantity' => 'required|integer|min:1',
            'type' => 'required|string',
            'unit_cost' => 'required|numeric|min:0',
            'date' => 'required|date',
        ]);
        return redirect()->route('manager.stock-outflow.index')
                         ->with('success', 'Sortie de stock enregistrée avec succès (données fictives)');
    }
}