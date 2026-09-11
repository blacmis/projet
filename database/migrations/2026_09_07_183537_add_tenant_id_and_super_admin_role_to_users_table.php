<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'tenant_id')) {
                $table->foreignId('tenant_id')->nullable()->after('id')
                    ->constrained('tenants')->restrictOnDelete();
            }
        });

        // Ajoute 'super_admin' aux rôles possibles, sans toucher aux valeurs déjà en base.
        DB::statement("ALTER TABLE users MODIFY role ENUM('admin','manager','cashier','super_admin') NOT NULL DEFAULT 'cashier'");

        // L'email n'est plus unique sur toute la plateforme, seulement PAR supermarché.
        $existingIndex = DB::select("SHOW INDEX FROM users WHERE Key_name = 'users_email_unique'");
        if (count($existingIndex) > 0) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropUnique('users_email_unique');
            });
        }

        Schema::table('users', function (Blueprint $table) {
            $table->unique(['email', 'tenant_id'], 'users_email_tenant_unique');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropUnique('users_email_tenant_unique');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->unique('email', 'users_email_unique');
        });

        DB::statement("ALTER TABLE users MODIFY role ENUM('admin','manager','cashier') NOT NULL DEFAULT 'cashier'");

        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'tenant_id')) {
                $table->dropForeign(['tenant_id']);
                $table->dropColumn('tenant_id');
            }
        });
    }
};