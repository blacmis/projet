<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    private array $businessTables = [
        'products', 'categories', 'units', 'suppliers',
        'stock_inflows', 'stock_outflows', 'stock_adjustments',
        'expired_damaged_goods', 'sales', 'sale_items',
        'cashier_notifications', 'activity_logs', 'settings',
        'cash_register_sessions',
    ];

    public function up(): void
    {
        foreach ($this->businessTables as $tableName) {
            if (!Schema::hasTable($tableName) || !Schema::hasColumn($tableName, 'tenant_id')) {
                continue;
            }

            DB::statement("ALTER TABLE `{$tableName}` MODIFY tenant_id BIGINT UNSIGNED NOT NULL");
        }
    }

    public function down(): void
    {
        foreach ($this->businessTables as $tableName) {
            if (!Schema::hasTable($tableName) || !Schema::hasColumn($tableName, 'tenant_id')) {
                continue;
            }

            DB::statement("ALTER TABLE `{$tableName}` MODIFY tenant_id BIGINT UNSIGNED NULL");
        }
    }
};