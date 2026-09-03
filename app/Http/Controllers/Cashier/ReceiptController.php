<?php

namespace App\Http\Controllers\Cashier;

use App\Http\Controllers\Controller;
use App\Models\Sale;

class ReceiptController extends Controller
{
    public function receipt($sale = null)
    {
        $sale = Sale::with('items')->find($sale);

        if (!$sale) {
            return redirect()->route('cashier.payment')
                ->with('error', 'No completed sale exists yet.');
        }

        return view('cashier.receipt', compact('sale'));
    }
}