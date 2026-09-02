<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('store_name')->default('MarketSmart MARKET');
            $table->string('store_address')->nullable();
            $table->string('store_phone')->nullable();
            $table->string('currency', 10)->default('XAF');
            $table->decimal('tax_rate', 5, 2)->default(0);
            $table->string('receipt_footer')->nullable();
            $table->unsignedInteger('low_stock_threshold')->default(20);
            $table->unsignedInteger('expiry_alert_days')->default(7);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};