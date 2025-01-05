<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class GroupsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        // Fetch all department IDs to associate with groups
        $departmentIds = DB::table('departments')->pluck('id');

        // Check if there are departments available
        if ($departmentIds->isEmpty()) {
            $this->command->warn("No departments found. Please seed the departments table first.");
            return;
        }

        // Generate 50 fake groups
        foreach (range(1, 50) as $index) {
            DB::table('groups')->insert([
                'name' => $faker->unique()->word, // A unique name for the group
                'department_id' => $faker->randomElement($departmentIds), // Randomly associate with a department
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
