<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->unsignedInteger('reference_stock')->nullable()->after('stock_quantity');
        });

        // Pour tes produits déjà existants : leur stock actuel devient leur référence de départ
        DB::table('products')->whereNull('reference_stock')->update([
            'reference_stock' => DB::raw('stock_quantity'),
        ]);
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('reference_stock');
        });
    }
};