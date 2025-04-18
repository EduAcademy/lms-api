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
        $levelIds = DB::table('levels')->pluck('id');

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
            $subGroupIds->isEmpty() ||
            $levelIds->isEmpty()
        ) {
            $this->command->warn("Some related tables are empty. Please seed departments, study plans, groups, and sub-groups first.");
            return;
        }

        // Create a default student if not exists (similar to the default admin in UserSeeder)
        if (!User::where('email', 'messi@su.edu.ye')->exists()) {
            // Set fixed default values
            $defaultUuid = '2210000'; // A fixed 8-digit number; change as needed.
            $defaultEmail = 'messi@su.edu.ye';
            $defaultImage = 'users/7.jpg';

            // Create default user for student
            $defaultUser = User::factory()->create([
                'role_id'           => $studentRole->id,
                'email'             => $defaultEmail,
                'password'          => bcrypt('aaaa1111'), // You can adjust the password
                'first_name'        => 'Leo',
                'last_name'         => 'Messi',
                'phone'             => '0000000000',
                'is_active'         => 1,
                'gender'            => 'male',
                'email_verified_at' => now(),
                'image_url'         => $defaultImage,
                'remember_token'    => Str::random(10),
            ]);

            // Create a student record linked to the default user
            DB::table('students')->insert([
                'uuid'           => $defaultUuid,
                'department_id'  => $faker->randomElement($departmentIds),
                'study_plan_id'  => $faker->randomElement($studyPlanIds),
                'user_id'        => $defaultUser->id,
                'group_id'       => $faker->randomElement($groupIds),
                'sub_group_id'   => $faker->randomElement($subGroupIds),
                'level_id'       => $faker->randomElement($levelIds),
                'created_at'     => now(),
                'updated_at'     => now(),
            ]);
        }

        // Generate 100 fake students by creating a user and linking it to a student record
        foreach (range(1, 2) as $index) {
            // Generate a random 8-digit number for uuid
            $randomNumber = random_int(10000000, 99999999);
            $uuid = (string)$randomNumber;
            $email = $uuid . '@su.edu.ye';

            // Select a random image between 1.jpg and 10.jpg
            $randomImage = 'users/' . rand(1, 10) . '.jpg';

            // Create a new user with the student role, assigned email and random image
            $user = User::factory()->create([
                'role_id'   => $studentRole->id,
                'email'     => $email,
                'image_url' => $randomImage,
            ]);

            // Create a student record linked to the newly created user using the same random number as uuid
            DB::table('students')->insert([
                'uuid'           => $uuid,
                'department_id'  => $faker->randomElement($departmentIds),
                'study_plan_id'  => $faker->randomElement($studyPlanIds),
                'user_id'        => $user->id,
                'group_id'       => $faker->randomElement($groupIds),
                'sub_group_id'   => $faker->randomElement($subGroupIds),
                'level_id'       => $faker->randomElement($levelIds),
                'created_at'     => now(),
                'updated_at'     => now(),
            ]);
        }
    }
}