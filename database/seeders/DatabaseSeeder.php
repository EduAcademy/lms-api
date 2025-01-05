<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $this->call(RoleSeeder::class);
        $this->call(DepartmentSeeder::class);
        $this->call(StudyPlanSeeder::class);
        $this->call(GroupsSeeder::class);
        $this->call(SubGroupsSeeder::class);
        $this->call(StudentsSeeder::class);
        $this->call(AdminsSeeder::class);
        $this->call(CoursesSeeder::class);
        $this->call(CourseMaterialsSeeder::class);
        $this->call(LevelsSeeder::class);
        $this->call(StudyPlanCoursesSeeder::class);
        $this->call(SpcInstructorsSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(InstructorSeeder::class);
    }
}
