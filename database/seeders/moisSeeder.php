<?php

namespace Database\Seeders;

use App\Models\moi;
use Illuminate\Database\Seeder;


class moisSeeder extends Seeder
{
    public function run(): void
    {
        moi::create([
            'name' => 'ori',
            'category' => 'toi',
            'slug' => 'ensemble',
        ]);
        
    }
}
