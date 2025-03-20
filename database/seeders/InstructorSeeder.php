<?php

namespace Database\Seeders;

use App\Models\Instructor;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InstructorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $total = 50; // Total instructors to generate

        // Fetch the instructor role by its name
        $instructorRole = DB::table('roles')->where('name', 'instructor')->first();
        if (!$instructorRole) {
            $this->command->warn("Instructor role not found. Please seed roles first.");
            return;
        }

        // Generate instructors by creating a new user and linking it to an instructor record
        foreach (range(1, $total) as $index) {
            // Select a random image between 1.jpg and 10.jpg
            $randomImage = 'storage/users/' . rand(1, 10) . '.jpg';

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
