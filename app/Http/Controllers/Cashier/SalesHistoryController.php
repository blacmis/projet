<?php

namespace App\Http\Controllers\Cashier;

use App\Http\Controllers\Controller;
use App\Models\Sale;
use Illuminate\Http\Request;

class SalesHistoryController extends Controller
{
    public function salesHistory(Request $request)
    {
        $query = Sale::with('items')->orderByDesc('created_at');

        if ($request->filled('search')) {
            $search = $request->string('search');
            $query->where(function ($q) use ($search) {
                $q->where('transaction_number', 'like', "%{$search}%")
                  ->orWhere('payment_method', 'like', "%{$search}%");
            });
        }

        if ($request->filled('payment_method')) {
            $query->where('payment_method', $request->payment_method);
        }

        $sales = $query->get();

        return view('cashier.sales-history', compact('sales'));
    }

    public function showSale($sale)
    {
        $sale = Sale::with('items')->find($sale);

        if (!$sale) {
            return redirect()->route('cashier.sales')
                ->with('error', 'Vente introuvable.');
        }

        return view('cashier.sale-show', compact('sale'));
    }
}