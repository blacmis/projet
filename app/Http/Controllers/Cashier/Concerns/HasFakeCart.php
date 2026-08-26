<?php

namespace App\Http\Controllers\Cashier\Concerns;

use Illuminate\Http\Request;

trait HasFakeCart
{
    private function fakeProducts()
    {
        return collect([
            (object) [
                'id' => 1,
                'name' => 'Rice 5kg',
                'barcode' => '1001',
                'price' => 2500,
                'selling_price' => 2500,
                'stock_quantity' => 150,
                'quantity' => 150,
                'category' => 'Grains',
                'is_active' => true,
            ],
            (object) [
                'id' => 2,
                'name' => 'Cooking Oil 2L',
                'barcode' => '1002',
                'price' => 3500,
                'selling_price' => 3500,
                'stock_quantity' => 80,
                'quantity' => 80,
                'category' => 'Beverage',
                'is_active' => true,
            ],
            (object) [
                'id' => 3,
                'name' => 'Sugar 5kg',
                'barcode' => '1003',
                'price' => 2200,
                'selling_price' => 2200,
                'stock_quantity' => 60,
                'quantity' => 60,
                'category' => 'Groceries',
                'is_active' => true,
            ],
            (object) [
                'id' => 4,
                'name' => 'Milk 1L',
                'barcode' => '1004',
                'price' => 500,
                'selling_price' => 500,
                'stock_quantity' => 120,
                'quantity' => 120,
                'category' => 'Dairy',
                'is_active' => true,
            ],
            (object) [
                'id' => 5,
                'name' => 'White Flour 25kg',
                'barcode' => '1005',
                'price' => 1000,
                'selling_price' => 1000,
                'stock_quantity' => 40,
                'quantity' => 40,
                'category' => 'Groceries',
                'is_active' => true,
            ],
        ]);
    }

    private function findFakeProduct($id)
    {
        return $this->fakeProducts()->firstWhere('id', (int) $id);
    }

    private function cart(Request $request): array
    {
        return $request->session()->get('cashier_cart', []);
    }

    private function cartTotals(array $cart): array
    {
        $subtotal = collect($cart)->sum(fn ($item) => $item['price'] * $item['quantity']);
        $discount = collect($cart)->sum(fn ($item) => ($item['discount'] ?? 0) * $item['quantity']);
        $tax = 0;
        $total = max(0, $subtotal - $discount + $tax);

        return compact('subtotal', 'discount', 'tax', 'total');
    }
}