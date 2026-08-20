<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\CashierNotification;
use Illuminate\Database\Seeder;

class CashierSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            ['Coca Cola 50cl', '100001', 'Beverages', 650, 50, 5],
            ['Bread Premium', '100002', 'Bakery', 550, 35, 5],
            ['Milk 1L', '100003', 'Dairy', 1200, 24, 5],
            ['Orange Juice', '100004', 'Beverages', 1500, 30, 5],
            ['Rice 5kg', '100005', 'Groceries', 5500, 18, 4],
            ['Sugar 1kg', '100006', 'Groceries', 900, 40, 5],
            ['Biscuits', '100007', 'Snacks', 700, 45, 8],
            ['Water 1.5L', '100008', 'Beverages', 400, 60, 10],
        ];

        foreach ($products as $p) {
            Product::updateOrCreate(
                ['barcode' => $p[1]],
                [
                    'name' => $p[0],
                    'category' => $p[2],
                    'price' => $p[3],
                    'stock_quantity' => $p[4],
                    'low_stock_threshold' => $p[5],
                    'is_active' => true,
                ]
            );
        }

        CashierNotification::create([
            'title' => 'Welcome to MarketSmart',
            'message' => 'The cashier module is ready. You can create sales, print receipts and monitor daily performance.',
            'type' => 'general',
            'is_read' => false,
        ]);
    }
}
