<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class StudyPlanCoursesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        // Fetch existing study plan IDs from the database
        $existingStudyPlanIds = DB::table('study_plans')->pluck('id')->toArray();

        // Generate 10 random study plan courses
        foreach (range(1, 10) as $index) {
            DB::table('study_plan_courses')->insert([
                'study_plan_id' => $faker->randomElement($existingStudyPlanIds), // Ensure valid study plan ID
                'department_id' => $faker->numberBetween(1, 3), // Random department ID
                'course_id' => $faker->numberBetween(1, 8), // Random course ID
                'level_id' => $faker->numberBetween(1, 3), // Random level ID
                'semester' => $faker->randomElement(['1', '2']), // Random semester ('1' or '2')
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
