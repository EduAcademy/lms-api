<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        $roleIds = DB::table('roles')->pluck('id');

        if (!User::where('email', 'test@test.com')->exists()) {
            if ($roleIds->isNotEmpty()) {
                User::factory()->create([
                    'email' => 'test@test.com',
                    'password' => bcrypt('123456'),
                    'role_id' => $roleIds->random(),
                    'email_verified_at' => now(),
                    'first_name' => 'Admin',
                    'last_name' => 'Admin',
                    'phone' => '1234567890',
                    'is_active' => 0,
                    'gender' => 'male',
                    'remember_token' => Str::random(10),
                ]);
            } else {
                Log::warning('No roles available to assign to the user. Please seed roles first.');
            }
        }

        for ($i = 0; $i < $total / $chunks; $i++) {
            User::factory()->count($chunks)->create();
        }
    }
}
