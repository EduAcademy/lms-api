<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class SpcInstructorsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        // Generate 10 random SPC instructors
        foreach (range(1, 10) as $index) {
            DB::table('spc_instructors')->insert([
                'study_plan_course_id' => $faker->numberBetween(1, 10), // Random study plan course ID
                'group_id' => $faker->numberBetween(1, 5), // Random group ID
                'instructor_id' => $faker->numberBetween(1, 10), // Random instructor ID
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
