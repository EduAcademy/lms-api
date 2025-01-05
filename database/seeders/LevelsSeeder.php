<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class LevelsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        // Create a few fake levels
        foreach (range(1, 5) as $index) {
            DB::table('levels')->insert([
                'name' => $faker->word, // Random name for the level
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
