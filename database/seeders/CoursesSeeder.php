<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class CoursesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        // Generate 50 fake courses
        foreach (range(1, 50) as $index) {
            DB::table('courses')->insert([
                'name' => $faker->words(3, true), // Random course name
                'description' => $faker->sentence(10), // Random course description
                'course_code' => strtoupper($faker->lexify('????-???')), // Random course code (e.g., ABCD-123)
                'course_hours' => $faker->numberBetween(1, 8), // Random course hours between 1 and 8
                'type' => $faker->randomElement(['core', 'elective']), // Random type: core or elective
                'group_hours' => $faker->numberBetween(0, 4), // Random group hours between 0 and 4
                'sub_group_hours' => $faker->numberBetween(0, 4), // Random sub-group hours between 0 and 4
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
