<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Faker\Factory as Faker;
class StudyPlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $chunks = 99; // Insert rows in chunks
        $total = 99; // Total rows
        $faker = Faker::create();

        // Generate 50 fake study plans
        for ($i = 0; $i < $total / $chunks; $i++) {
            DB::table('study_plans')->insert([
                'name' => $faker->unique()->sentence(3), // A unique name with 3 words
                'number' => $faker->numberBetween(1, 100), // A random number between 1 and 100
                'start_date' => $faker->dateTimeBetween('-1 year', 'now')->format('Y-m-d'), // Random date within the past year
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
