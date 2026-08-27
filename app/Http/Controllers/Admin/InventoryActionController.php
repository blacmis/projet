<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\AuditLogController;
class InventoryActionController extends Controller
{
    private function defaultProducts(): array
    {
        return [
            ['id' => 1, 'code' => '00001', 'name' => 'Coca Cola 1L', 'category' => 'Beverage', 'stock' => 100, 'min_stock' => 20, 'status' => 'In Stock'],
            ['id' => 2, 'code' => '00002', 'name' => 'Rice 50kg', 'category' => 'Grains', 'stock' => 30, 'min_stock' => 40, 'status' => 'Low Stock'],
            ['id' => 3, 'code' => '00003', 'name' => 'Sardine', 'category' => 'Grocery', 'stock' => 0, 'min_stock' => 15, 'status' => 'Out of Stock'],
            ['id' => 4, 'code' => '00004', 'name' => 'Detol Soap', 'category' => 'Household', 'stock' => 50, 'min_stock' => 10, 'status' => 'In Stock'],
            ['id' => 5, 'code' => '00005', 'name' => 'Chicken Egg (30pcs)', 'category' => 'Grocery', 'stock' => 20, 'min_stock' => 25, 'status' => 'Low Stock'],
        ];
    }
    private function getProducts(): array
    {
        if (!session()->has('admin_inventory')) {
            session(['admin_inventory' => $this->defaultProducts()]);
        }
        return session('admin_inventory');
    }
    private function saveProducts(array $products): void
    {
        session(['admin_inventory' => array_values($products)]);
    }
    private function refreshStatus(array &$product): void
    {
        if ($product['stock'] <= 0) {
            $product['status'] = 'Out of Stock';
        } elseif ($product['stock'] <= $product['min_stock']) {
            $product['status'] = 'Low Stock';
        } else {
            $product['status'] = 'In Stock';
        }
    }
    public function index(Request $request)
    {
        $products = collect($this->getProducts());
        if ($request->filled('q')) {
            $q = strtolower($request->q);
            $products = $products->filter(function ($p) use ($q) {
                return str_contains(strtolower($p['name']), $q)
                    || str_contains(strtolower($p['code']), $q);
            })->values();
        }
        if ($request->filled('status') && $request->status !== 'all') {
            $products = $products->where('status', $request->status)->values();
        }
        return view('admin.inventory-actions.index', [
            'products' => $products,
        ]);
    }
    public function adjust(Request $request, $id)
    {
        $request->validate([
            'type' => 'required|in:add,remove,set',
            'quantity' => 'required|integer|min:0',
        ]);
        $products = $this->getProducts();
        $found = false;
        foreach ($products as $i => $p) {
            if ((int) $p['id'] === (int) $id) {
                if ($request->type === 'add') {
                    $products[$i]['stock'] += (int) $request->quantity;
                } elseif ($request->type === 'remove') {
                    $products[$i]['stock'] = max(0, $products[$i]['stock'] - (int) $request->quantity);
                } else {
                    $products[$i]['stock'] = (int) $request->quantity;
                }
                $this->refreshStatus($products[$i]);
                $found = true;
                break;
            }
        }
        if (!$found) {
            return back()->with('error', 'Produit introuvable.');
        }
        $this->saveProducts($products);
            AuditLogController::log(
                'STOCK_ADJUST',
                'Product ID '.$id.' type='.$request->type.' qty='.$request->quantity
            );
            return back()->with('success', 'Stock mis à jour par l\'administrateur.');
    }
    public function setStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:In Stock,Low Stock,Out of Stock,Unavailable',
        ]);
        $products = $this->getProducts();
        $found = false;
        foreach ($products as $i => $p) {
            if ((int) $p['id'] === (int) $id) {
                $products[$i]['status'] = $request->status;
                if ($request->status === 'Out of Stock' || $request->status === 'Unavailable') {
                    // optionnel : ne force pas stock à 0 pour Unavailable
                }
                $found = true;
                break;
            }
        }
        if (!$found) {
            return back()->with('error', 'Produit introuvable.');
        }
        $this->saveProducts($products);
        AuditLogController::log('STOCK_STATUS', 'Product ID '.$id.' status='.$request->status);
        return back()->with('success', 'Statut produit mis à jour.');
    }
}