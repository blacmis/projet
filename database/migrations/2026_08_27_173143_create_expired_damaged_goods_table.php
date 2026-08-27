<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('expired_damaged_goods', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->string('batch_no')->nullable();
            $table->enum('type', ['expired', 'damaged']);
            $table->unsignedInteger('quantity');
            $table->date('expiry_date')->nullable();
            $table->decimal('estimated_loss', 12, 2)->default(0);
            $table->string('status')->default('Retiré du stock');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('expired_damaged_goods');
    }
};