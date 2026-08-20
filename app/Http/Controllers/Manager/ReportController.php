<?php
namespace App\Http\Controllers\Manager;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
class ReportController extends Controller
{
    public function inventory(Request $request)
    {
        $allItems = [
            [
                'id' => 1,
                'product' => 'Rice 5kg',
                'category' => 'Grains',
                'quantity' => 150,
                'unit' => 'Bag',
                'value' => 375000,
            ],
            [
                'id' => 2,
                'product' => 'Cooking Oil 2L',
                'category' => 'Beverage',
                'quantity' => 80,
                'unit' => 'Piece',
                'value' => 280000,
            ],
            [
                'id' => 3,
                'product' => 'Sugar 5kg',
                'category' => 'Groceries',
                'quantity' => 60,
                'unit' => 'Bag',
                'value' => 132000,
            ],
            [
                'id' => 4,
                'product' => 'Milk 1L',
                'category' => 'Dairy',
                'quantity' => 120,
                'unit' => 'Piece',
                'value' => 60000,
            ],
            [
                'id' => 5,
                'product' => 'White Flour 25kg',
                'category' => 'Groceries',
                'quantity' => 40,
                'unit' => 'Bag',
                'value' => 40000,
            ],
        ];
        $search = $request->input('search');
        if ($search) {
            $items = array_filter($allItems, function ($item) use ($search) {
                return str_contains(strtolower($item['product']), strtolower($search)) ||
                       str_contains(strtolower($item['category']), strtolower($search));
            });
        } else {
            $items = $allItems;
        }
        $totalValue = array_sum(array_column($allItems, 'value'));
        $totalProducts = count($allItems);
        return view('manager.reports.inventory', compact('items', 'search', 'totalValue', 'totalProducts'));
    }
    public function lowStock(Request $request)
    {
        $allLowStock = [
            [
                'id' => 1,
                'product' => 'Sucre 50 kg',
                'current_stock' => 8,
                'min_stock' => 20,
                'status' => 'Stock faible',
            ],
            [
                'id' => 2,
                'product' => 'Farine de blé 25 kg',
                'current_stock' => 6,
                'min_stock' => 15,
                'status' => 'Stock faible',
            ],
            [
                'id' => 3,
                'product' => 'Huile de cuisson 20L',
                'current_stock' => 5,
                'min_stock' => 10,
                'status' => 'Stock faible',
            ],
            [
                'id' => 4,
                'product' => 'Feuilles de thé 1 kg',
                'current_stock' => 3,
                'min_stock' => 10,
                'status' => 'Stock faible',
            ],
            [
                'id' => 5,
                'product' => 'Sel 1 kg',
                'current_stock' => 4,
                'min_stock' => 10,
                'status' => 'Stock faible',
            ],
        ];
        $search = $request->input('search');
        if ($search) {
            $items = array_filter($allLowStock, function ($item) use ($search) {
                return str_contains(strtolower($item['product']), strtolower($search));
            });
        } else {
            $items = $allLowStock;
        }
        return view('manager.reports.low-stock', compact('items', 'search'));
    }
}