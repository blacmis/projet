<?php

namespace App\Http\Controllers\Cashier;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Cashier\Concerns\HasFakeCart;
use Illuminate\Http\Request;

class QuickShopController extends Controller
{
    use HasFakeCart;

    public function quickShop(Request $request)
    {
        $products = $this->fakeProducts();
        $categories = $products->pluck('category')->unique()->values();

        if ($request->filled('search')) {
            $search = strtolower($request->string('search'));
            $products = $products->filter(function ($p) use ($search) {
                return str_contains(strtolower($p->name), $search)
                    || str_contains(strtolower($p->barcode), $search);
            })->values();
        }

        if ($request->filled('category')) {
            $products = $products->where('category', $request->category)->values();
        }

        return view('cashier.quick-shop', compact('products', 'categories'));
    }
}