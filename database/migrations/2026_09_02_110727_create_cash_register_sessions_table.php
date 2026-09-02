<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('cash_register_sessions', function (Blueprint $table) {
            $table->id();
            $table->string('cashier_email');
            $table->string('cashier_name');
            $table->decimal('opening_amount', 12, 2);
            $table->timestamp('opened_at');
            $table->decimal('expected_cash', 12, 2)->nullable();
            $table->decimal('expected_mobile_money', 12, 2)->nullable();
            $table->decimal('expected_card', 12, 2)->nullable();
            $table->decimal('counted_cash', 12, 2)->nullable();
            $table->decimal('counted_mobile_money', 12, 2)->nullable();
            $table->decimal('counted_card', 12, 2)->nullable();
            $table->decimal('variance', 12, 2)->nullable();
            $table->text('closing_notes')->nullable();
            $table->timestamp('closed_at')->nullable();
            $table->enum('status', ['open', 'closed'])->default('open');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cash_register_sessions');
    }
};