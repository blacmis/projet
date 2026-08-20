<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class sessionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        session::create([
            'id',
            'user_id',
            'ip_address',
            'user_agent','payload',
            'last_activity',
            'name' => 'ori',
            'category' => 'toi',
            'slug' => 'ensemble',
        ]);
    }
}
