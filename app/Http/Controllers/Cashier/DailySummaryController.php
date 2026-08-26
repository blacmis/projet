<?php

namespace App\Http\Controllers\Cashier;

use App\Http\Controllers\Controller;

class DailySummaryController extends Controller
{
    public function dailySummary()
    {
        $revenue = 27700;
        $salesCount = 3;
        $itemsSold = 12;
        $refunds = 0;
        $cash = 8500;
        $mobileMoney = 4200;
        $card = 15000;
        $hourly = collect([
            '08:00' => 0,
            '09:00' => 8500,
            '10:00' => 4200,
            '11:00' => 15000,
        ]);

        return view('cashier.daily-summary', compact(
            'revenue', 'salesCount', 'itemsSold', 'refunds',
            'cash', 'mobileMoney', 'card', 'hourly'
        ));
    }
}