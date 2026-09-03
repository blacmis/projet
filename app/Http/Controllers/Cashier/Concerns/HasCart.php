<?php

namespace App\Http\Controllers\Cashier\Concerns;

use Illuminate\Http\Request;

trait HasCart
{
    protected function cart(Request $request): array
    {
        return $request->session()->get('cashier_cart', []);
    }

    protected function cartTotals(array $cart, float $discount = 0): array
    {
        $subtotal = collect($cart)->sum(fn ($item) => $item['price'] * $item['quantity']);
        $discount = min($discount, $subtotal);
        $tax = 0;
        $total = $subtotal - $discount + $tax;

        return [
            'subtotal' => $subtotal,
            'discount' => $discount,
            'tax' => $tax,
            'total' => $total,
        ];
    }
}