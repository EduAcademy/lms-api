<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use Illuminate\Support\Str;

class AdminsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        // Assuming there are already users in the users table, we fetch a random user
        $userIds = DB::table('users')->pluck('id')->toArray();

        // Generate 10 fake admins
        foreach (range(1, 10) as $index) {
            DB::table('admins')->insert([
                'uuid' => Str::uuid()->toString(), // Random UUID
                'user_id' => $faker->randomElement($userIds), // Random user ID from the existing users table
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
