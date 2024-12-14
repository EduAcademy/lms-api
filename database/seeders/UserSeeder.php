<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $chunks = 99; // Insert rows in chunks
        $total = 99; // Total rows

        User::factory()->count(1)->create(
            [
                'email' => 'test@test.com',
                'password' => bcrypt('123456'),
                'role_id' => 1,
                'email_verified_at' => now(),
                'first_name' => 'Admin',
                'last_name' => 'Admin',
                'phone' => '1234567890',
                'address' => 'Admin Address',
                'status' => 'active',
                'gender' => 'male',
                'remember_token' => Str::random(10),
            ]
        );
        for ($i = 0; $i < $total / $chunks; $i++) {
            User::factory()->count($chunks)->create();
        }
    }
}
