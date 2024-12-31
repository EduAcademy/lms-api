<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;
use App\Enums\RoleType;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::insert([
            ['name' => RoleType::Admin, 'description' => 'Administrator'],
            ['name' => RoleType::Instructor, 'description' => 'Instructor'],
            ['name' => RoleType::Student, 'description' => 'Student'],
        ]);
    }
}
