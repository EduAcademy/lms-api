<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class SpcISubGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        // Fetch existing study plan course IDs from the database
        $existingStudyPlanCourseInstructorsIds = DB::table('spc_instructors')->pluck('id')->toArray();

        // Generate 10 random SPC instructors
        foreach (range(1, 30) as $index) {
            DB::table('spc_instructor_sub_groups')->insert([
                'spc_instructor_id' => $faker->randomElement($existingStudyPlanCourseInstructorsIds), // Valid study plan course ID
                'sub_group_id' => $faker->numberBetween(1, 5), // Random group ID
                'instructor_id' => $faker->numberBetween(1, 10), // Random instructor ID
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
