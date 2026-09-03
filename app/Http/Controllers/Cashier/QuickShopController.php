<?php

namespace App\Http\Controllers\Cashier;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class QuickShopController extends Controller
{
    public function quickShop(Request $request)
    {
        $query = Product::query();

        if ($request->filled('search')) {
            $search = $request->string('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('barcode', 'like', "%{$search}%");
            });
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        $products = $query->orderBy('name')->get();
        $categories = Product::whereNotNull('category')->distinct()->pluck('category');

        return view('cashier.quick-shop', compact('products', 'categories'));
    }
}