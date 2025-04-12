<?php

namespace Database\Seeders;

use App\Models\Instructor;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class InstructorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Fetch the instructor role by its name
        $instructorRole = DB::table('roles')->where('name', 'instructor')->first();
        if (!$instructorRole) {
            $this->command->warn("Instructor role not found. Please seed roles first.");
            return;
        }

        // Create a default instructor if not exists (similar to the default admin)
        if (!User::where('email', 'Ronaldo@instructor.com')->exists()) {
            $defaultImage = 'users/1.jpg'; // You can change the default image if needed

            // Create the default user for instructor
            $defaultUser = User::factory()->create([
                'role_id'           => $instructorRole->id,
                'email'             => 'Ronaldo@instructor.com',
                'password'          => Hash::make('aaaa1111'), // Adjust the password as needed
                'first_name'        => 'Cristiano',
                'last_name'         => 'Ronaldo',
                'phone'             => '0000000000',
                'is_active'         => 1,
                'gender'            => 'male',
                'email_verified_at' => now(),
                'image_url'         => $defaultImage,
                'remember_token'    => Str::random(10),
            ]);

            // Create the instructor record linked to the default user
            Instructor::factory()->create([
                'user_id' => $defaultUser->id,
            ]);
        }

        $total = 5; // Total instructors to generate

        // Generate additional instructors by creating a new user and linking it to an instructor record
        foreach (range(1, $total) as $index) {
            // Select a random image between 1.jpg and 10.jpg
            $randomImage = 'users/' . rand(1, 5) . '.jpg';

            // Create a new user with the instructor role and assign a random image
            $user = User::factory()->create([
                'role_id'   => $instructorRole->id,
                'image_url' => $randomImage,
            ]);

            // Create an instructor record linked to the newly created user
            Instructor::factory()->create([
                'user_id' => $user->id,
            ]);
        }
    }
}
