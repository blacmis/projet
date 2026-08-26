<?php

namespace App\Http\Controllers\Cashier;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SalesHistoryController extends Controller
{
    public function salesHistory(Request $request)
    {
        $sales = collect([
            (object) [
                'id' => 1,
                'transaction_number' => 'MS-260821-101',
                'total' => 8500,
                'payment_method' => 'cash',
                'status' => 'completed',
                'created_at' => now()->subHours(2),
                'items' => collect([(object) ['quantity' => 3], (object) ['quantity' => 2]]),
            ],
            (object) [
                'id' => 2,
                'transaction_number' => 'MS-260821-102',
                'total' => 4200,
                'payment_method' => 'mobile_money',
                'status' => 'completed',
                'created_at' => now()->subHours(1),
                'items' => collect([(object) ['quantity' => 4]]),
            ],
            (object) [
                'id' => 3,
                'transaction_number' => 'MS-260821-103',
                'total' => 15000,
                'payment_method' => 'card',
                'status' => 'completed',
                'created_at' => now(),
                'items' => collect([(object) ['quantity' => 5], (object) ['quantity' => 1]]),
            ],
        ]);

        if ($request->filled('search')) {
            $search = strtolower(trim($request->string('search')));
            $sales = $sales->filter(function ($sale) use ($search) {
                return str_contains(strtolower($sale->transaction_number), $search)
                    || str_contains(strtolower(str_replace('_', ' ', $sale->payment_method)), $search);
            })->values();
        }

        if ($request->filled('payment_method') && $request->payment_method !== '') {
            $method = strtolower(trim($request->payment_method));
            $sales = $sales->filter(fn ($sale) => strtolower($sale->payment_method) === $method)->values();
        }

        return view('cashier.sales-history', compact('sales'));
    }

    public function showSale($sale)
    {
        $saleData = session('last_sale');
        if (!$saleData) {
            $saleData = [
                'id' => $sale,
                'transaction_number' => 'MS-DEMO-' . $sale,
                'total' => 0,
                'items' => [],
                'created_at' => now()->format('d/m/Y H:i'),
            ];
        }

        $sale = (object) $saleData;

        return view('cashier.sale-show', compact('sale'));
    }
}