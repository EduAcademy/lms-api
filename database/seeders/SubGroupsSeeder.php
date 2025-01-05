<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class SubGroupsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        // Fetch all group IDs and instructor IDs
        $groupIds = DB::table('groups')->pluck('id');
        $instructorIds = DB::table('instructors')->pluck('id');

        // Check if there are groups and instructors available
        if ($groupIds->isEmpty() || $instructorIds->isEmpty()) {
            $this->command->warn("No groups or instructors found. Please seed the groups and instructors tables first.");
            return;
        }

        // Generate 50 fake sub-groups
        foreach (range(1, 50) as $index) {
            DB::table('sub_groups')->insert([
                'name' => $faker->unique()->word, // A unique name for the sub-group
                'group_id' => $faker->randomElement($groupIds), // Randomly associate with a group
                'instructor_id' => $faker->randomElement($instructorIds), // Randomly associate with an instructor
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
