<?php
namespace App\Http\Controllers\Manager;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
class StockAdjustmentController extends Controller
{
    public function index(Request $request)
    {
        $allAdjustments = [
            [
                'id' => 1,
                'date' => '08/05/2026',
                'product' => 'Rice 50kg',
                'type' => 'Increase',
                'quantity' => 15,
                'reason' => 'Inventory recount',
            ],
            [
                'id' => 2,
                'date' => '07/05/2026',
                'product' => 'Cooking Oil 20L',
                'type' => 'Decrease',
                'quantity' => 5,
                'reason' => 'Damaged goods',
            ],
            [
                'id' => 3,
                'date' => '06/05/2026',
                'product' => 'Sugar 50kg',
                'type' => 'Increase',
                'quantity' => 10,
                'reason' => 'Found in storage',
            ],
            [
                'id' => 4,
                'date' => '05/05/2026',
                'product' => 'Milk 1L',
                'type' => 'Decrease',
                'quantity' => 8,
                'reason' => 'Expired items',
            ],
            [
                'id' => 5,
                'date' => '04/05/2026',
                'product' => 'White Flour 25kg',
                'type' => 'Increase',
                'quantity' => 12,
                'reason' => 'Stock correction',
            ],
        ];
        $search = $request->input('search');
        if ($search) {
            $adjustments = array_filter($allAdjustments, function ($item) use ($search) {
                return str_contains(strtolower($item['product']), strtolower($search)) ||
                       str_contains(strtolower($item['type']), strtolower($search)) ||
                       str_contains(strtolower($item['reason']), strtolower($search));
            });
        } else {
            $adjustments = $allAdjustments;
        }
        return view('manager.stock-adjustment.index', compact('adjustments', 'search'));
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
            'Increase',
            'Decrease',
        ];
        return view('manager.stock-adjustment.create', compact('products', 'types'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'product' => 'required|string',
            'type' => 'required|string',
            'quantity' => 'required|integer|min:1',
            'reason' => 'required|string|max:255',
            'date' => 'required|date',
        ]);
        return redirect()->route('manager.stock-adjustment.index')
                         ->with('success', 'Ajustement de stock enregistré avec succès (données fictives)');
    }
}