<?php
namespace App\Http\Controllers\Manager;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
class SupplierController extends Controller
{
    public function index(Request $request)
    {
        $allSuppliers = [
            [
                'id' => 1,
                'name' => 'ABC Suppliers',
                'phone' => '677 123 456',
                'email' => 'abc@suppliers.com',
            ],
            [
                'id' => 2,
                'name' => 'GoodFoods Ltd',
                'phone' => '677 234 567',
                'email' => 'info@goodfoods.com',
            ],
            [
                'id' => 3,
                'name' => 'Sweet Supply',
                'phone' => '677 345 678',
                'email' => 'sales@sweetsupply.com',
            ],
            [
                'id' => 4,
                'name' => 'Dairy Farm',
                'phone' => '677 456 789',
                'email' => 'contact@dairyfarm.com',
            ],
            [
                'id' => 5,
                'name' => 'Millers Ltd',
                'phone' => '677 567 890',
                'email' => 'info@millers.com',
            ],
        ];
        $search = $request->input('search');
        if ($search) {
            $suppliers = array_filter($allSuppliers, function ($supplier) use ($search) {
                return str_contains(strtolower($supplier['name']), strtolower($search)) ||
                       str_contains(strtolower($supplier['phone']), strtolower($search)) ||
                       str_contains(strtolower($supplier['email']), strtolower($search));
            });
        } else {
            $suppliers = $allSuppliers;
        }
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
        return redirect()->route('manager.suppliers.index')
                         ->with('success', 'Fournisseur ajouté avec succès (données fictives)');
    }
    public function edit(int $id)
    {
        $suppliers = [
            1 => [
                'id' => 1,
                'name' => 'ABC Suppliers',
                'phone' => '677 123 456',
                'email' => 'abc@suppliers.com',
            ],
            2 => [
                'id' => 2,
                'name' => 'GoodFoods Ltd',
                'phone' => '677 234 567',
                'email' => 'info@goodfoods.com',
            ],
            3 => [
                'id' => 3,
                'name' => 'Sweet Supply',
                'phone' => '677 345 678',
                'email' => 'sales@sweetsupply.com',
            ],
            4 => [
                'id' => 4,
                'name' => 'Dairy Farm',
                'phone' => '677 456 789',
                'email' => 'contact@dairyfarm.com',
            ],
            5 => [
                'id' => 5,
                'name' => 'Millers Ltd',
                'phone' => '677 567 890',
                'email' => 'info@millers.com',
            ],
        ];
        if (!isset($suppliers[$id])) {
            return redirect()->route('manager.suppliers.index')
                             ->with('error', 'Fournisseur introuvable');
        }
        $supplier = $suppliers[$id];
        return view('manager.suppliers.edit', compact('supplier'));
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
        ]);
        return redirect()->route('manager.suppliers.index')
                         ->with('success', 'Fournisseur modifié avec succès (données fictives)');
    }
    public function destroy($id)
    {
        return redirect()->route('manager.suppliers.index')
                         ->with('success', 'Fournisseur supprimé avec succès (données fictives)');
    }
}