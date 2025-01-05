<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class CourseMaterialsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        // Assuming there are courses and instructors already in the database
        $courseIds = DB::table('courses')->pluck('id')->toArray();
        $instructorIds = DB::table('instructors')->pluck('id')->toArray();

        // Generate 10 fake course materials
        foreach (range(1, 10) as $index) {
            DB::table('course_materials')->insert([
                'name' => $faker->sentence, // Random material name
                'type' => $faker->randomElement(['group', 'sub_group']), // Random type
                'url' => $faker->url, // Random URL
                'course_id' => $faker->randomElement($courseIds), // Random course ID from the existing courses table
                'instructor_id' => $faker->randomElement($instructorIds), // Random instructor ID from the existing instructors table
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
