<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

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
        $tenantId = DB::table('tenants')->where('name', 'MarketSmart Démo')->value('id');

        if (!$tenantId) {
            $tenantId = DB::table('tenants')->insertGetId([
                'name' => 'MarketSmart Démo',
                'sector' => 'Alimentaire',
                'status' => 'active',
                'subscribed_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Comptes utilisateurs : jamais toucher aux super_admin (tenant_id doit rester NULL pour eux).
        DB::table('users')
            ->whereNull('tenant_id')
            ->where('role', '!=', 'super_admin')
            ->update(['tenant_id' => $tenantId]);

        foreach ($this->businessTables as $tableName) {
            if (!Schema::hasTable($tableName) || !Schema::hasColumn($tableName, 'tenant_id')) {
                continue;
            }

            DB::table($tableName)->whereNull('tenant_id')->update(['tenant_id' => $tenantId]);
        }
    }

    public function down(): void
    {
        // Volontairement vide : on ne détache pas les données en cas de rollback.
    }
};