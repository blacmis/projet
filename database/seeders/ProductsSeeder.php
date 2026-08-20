<?php

namespace Database\Seeders;

use App\Models\Product;
use DB;
use Illuminate\Database\Seeder;

class ProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('products')->insert([
            [
            'name' => 'Coca Cola 50cl',
            'barcode' => '',
           'category' => 'Beverages',
           'price' => '650',
           'stock_quantity' => '50',
           'low_stock_threshold' => '5',
            ]
        ]);

    }
}