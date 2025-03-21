<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $chunks = 99; // Insert rows in chunks
        $total = 99; // Total rows

        // Fetch admin role by its name
        $adminRole = DB::table('roles')->where('name', 'admin')->first();
        if (!$adminRole) {
            Log::warning('Admin role not found. Please seed roles first.');
            return;
        }

        // Function to get a random image from 1.jpg to 10.jpg
        $getRandomImage = function () {
            return 'users/' . rand(1, 10) . '.jpg';
        };

        // Create a default admin if not exists
        if (!User::where('email', 'test@test.com')->exists()) {
            User::factory()->create([
                'email' => 'test@test.com',
                'password' => bcrypt('123456'),
                'role_id' => $adminRole->id,
                'email_verified_at' => now(),
                'first_name' => 'Admin',
                'last_name' => 'Admin',
                'phone' => '1234567890',
                'is_active' => 1,
                'gender' => 'male',
                'image_url' => $getRandomImage(), // Assign random image
                'remember_token' => Str::random(10),
            ]);
        }

        // Create additional admin users in chunks
        for ($i = 0; $i < $total / $chunks; $i++) {
            User::factory()->count($chunks)->create([
                'role_id' => $adminRole->id,
                'image_url' => $getRandomImage(), 
            ]);
        }
    }
}
