<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;
use App\Shared\Constants\RoleEnum;

class RoleTable extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::insert([
            ['name' => RoleEnum::Admin, 'description' => 'Administrator'],
            ['name' => RoleEnum::Instructor, 'description' => 'Instructor'],
            ['name' => RoleEnum::Student, 'description' => 'Student'],
        ]);
    }
}
