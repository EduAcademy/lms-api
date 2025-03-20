<?php

namespace Database\Seeders;

use App\Models\User;
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
        $groupIds = DB::table('groups')->pluck('id');
        $subGroupIds = DB::table('sub_groups')->pluck('id');

        // Fetch the student role by its name
        $studentRole = DB::table('roles')->where('name', 'student')->first();
        if (!$studentRole) {
            $this->command->warn("Student role not found. Please seed roles first.");
            return;
        }

        // Ensure required tables have data (excluding users since they will be created here)
        if (
            $departmentIds->isEmpty() ||
            $studyPlanIds->isEmpty() ||
            $groupIds->isEmpty() ||
            $subGroupIds->isEmpty()
        ) {
            $this->command->warn("Some related tables are empty. Please seed departments, study plans, groups, and sub-groups first.");
            return;
        }

        // Generate 100 fake students by creating a user and linking it to a student record
        foreach (range(1, 100) as $index) {
            // Generate a random 8-digit number
            $randomNumber = random_int(10000000, 99999999);
            $uuid = (string) $randomNumber;
            $email = $uuid . '@su.edu.ye';

            // Create a new user with the student role and assign the email using the random number
            $user = User::factory()->create([
                'role_id' => $studentRole->id,
                'email'   => $email,
            ]);

            // Create a student record linked to the newly created user using the same random number as uuid
            DB::table('students')->insert([
                'uuid' => $uuid,
                'department_id' => $faker->randomElement($departmentIds),
                'study_plan_id' => $faker->randomElement($studyPlanIds),
                'user_id' => $user->id,
                'group_id' => $faker->randomElement($groupIds),
                'sub_group_id' => $faker->randomElement($subGroupIds),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
