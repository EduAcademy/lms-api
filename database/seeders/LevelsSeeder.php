<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LevelsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $levels = [
            'level 1',
            'level 2',
            'level 3',
            'level 4',
        ];

        foreach ($levels as $levelName) {
            DB::table('levels')->insert([
                'name'       => $levelName,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
