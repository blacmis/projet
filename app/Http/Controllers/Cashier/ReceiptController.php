<?php

namespace App\Http\Controllers\Cashier;

use App\Http\Controllers\Controller;

class ReceiptController extends Controller
{
    public function receipt($sale = null)
    {
        $saleData = session('last_sale');
        if (!$saleData) {
            return redirect()->route('cashier.payment')
                ->with('error', 'No completed sale exists yet.');
        }

        $sale = (object) $saleData;

        if (isset($sale->created_at)) {
            if ($sale->created_at instanceof \Carbon\Carbon) {
                // ok
            } elseif (is_string($sale->created_at)) {
                try {
                    $sale->created_at = \Carbon\Carbon::createFromFormat('d/m/Y H:i', $sale->created_at);
                } catch (\Exception $e) {
                    $sale->created_at = now();
                }
            } else {
                $sale->created_at = now();
            }
        } else {
            $sale->created_at = now();
        }

        if (!isset($sale->cashier_name)) {
            $sale->cashier_name = 'Cashier User';
        }

        $items = [];
        foreach ($sale->items ?? [] as $item) {
            $item = (array) $item;
            $items[] = (object) [
                'product_name' => $item['name'] ?? $item['product_name'] ?? 'Produit',
                'quantity' => $item['quantity'] ?? 0,
                'unit_price' => $item['price'] ?? $item['unit_price'] ?? 0,
                'line_total' => ($item['price'] ?? $item['unit_price'] ?? 0) * ($item['quantity'] ?? 0),
            ];
        }
        $sale->items = $items;

        return view('cashier.receipt', compact('sale'));
    }
}