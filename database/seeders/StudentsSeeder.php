<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class StudentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        // Fetch all related IDs
        $departmentIds = DB::table('departments')->pluck('id');
        $studyPlanIds = DB::table('study_plans')->pluck('id');
        $userIds = DB::table('users')->pluck('id');
        $groupIds = DB::table('groups')->pluck('id');
        $subGroupIds = DB::table('sub_groups')->pluck('id');

        // Ensure all required tables have data
        if (
            $departmentIds->isEmpty() ||
            $studyPlanIds->isEmpty() ||
            $userIds->isEmpty() ||
            $groupIds->isEmpty() ||
            $subGroupIds->isEmpty()
        ) {
            $this->command->warn("Some related tables are empty. Please seed departments, study plans, users, groups, and sub-groups first.");
            return;
        }

        // Generate 100 fake students
        foreach (range(1, 100) as $index) {
            DB::table('students')->insert([
                'uuid' => Str::uuid()->toString(), // Generate a unique UUID
                'department_id' => $faker->randomElement($departmentIds), // Random department
                'study_plan_id' => $faker->randomElement($studyPlanIds), // Random study plan
                'user_id' => $faker->randomElement($userIds), // Random user
                'group_id' => $faker->randomElement($groupIds), // Random group
                'sub_group_id' => $faker->randomElement($subGroupIds), // Random sub-group
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
