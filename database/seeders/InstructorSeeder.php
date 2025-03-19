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
            // Create a new user with the instructor role
            $user = User::factory()->create([
                'role_id' => $instructorRole->id,
            ]);

            // Create an instructor record linked to the new created user
            Instructor::factory()->create([
                'user_id' => $user->id,
            ]);
        }
    }
}
