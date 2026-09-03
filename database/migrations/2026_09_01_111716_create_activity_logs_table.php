<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->string('user_name')->nullable();
            $table->string('role')->nullable();
            $table->string('activity_type'); // stock, sales, login, failed_login, system
            $table->string('action'); // libellé affiché : "Stock Received", "User Login"...
            $table->text('details')->nullable();
            $table->string('reference_id')->nullable();
            $table->string('ip_address')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};