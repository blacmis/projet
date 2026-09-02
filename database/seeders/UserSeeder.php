<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Comptes de démo
        User::firstOrCreate(
            ['email' => 'admin@marketsmart.com'],
            ['name' => 'Admin User', 'password' => 'password123', 'role' => 'admin', 'status' => 'active']
        );

        User::firstOrCreate(
            ['email' => 'manager@marketsmart.com'],
            ['name' => 'Inventory Manager', 'password' => 'password123', 'role' => 'manager', 'status' => 'active']
        );

        User::firstOrCreate(
            ['email' => 'cashier@marketsmart.com'],
            ['name' => 'Ange Cashier', 'password' => 'password123', 'role' => 'cashier', 'status' => 'active']
        );

        // Tes vrais comptes personnels
        User::firstOrCreate(
            ['email' => 'kuekamjeams@gmail.com'],
            ['name' => 'Jeams Kuekam', 'password' => 'blacmis123', 'role' => 'admin', 'status' => 'active']
        );

        User::firstOrCreate(
            ['email' => 'jeamsnael@gmail.com'],
            ['name' => 'Jeams Nael', 'password' => 'jeams123', 'role' => 'manager', 'status' => 'active']
        );

        User::firstOrCreate(
            ['email' => 'assonaapolince@yohoo.fr'],
            ['name' => 'Assona Apolince', 'password' => 'admin2026', 'role' => 'admin', 'status' => 'active']
        );

        // Nouveau compte admin de test
        User::firstOrCreate(
            ['email' => 'tonadresse@exemple.com'],
            ['name' => 'Test Admin', 'password' => 'motdepasse123', 'role' => 'admin', 'status' => 'active']
        );
    }
}
