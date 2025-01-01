<?php

namespace Database\Seeders;

use App\Enums\RoleType;
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

        $this->call(RoleType::class);
        $this->call(UserSeeder::class);
        $this->call(InstructorSeeder::class);
    }
}
