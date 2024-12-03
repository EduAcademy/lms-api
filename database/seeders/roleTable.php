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
            ['name' => RoleEnum::Admin],
            ['name' => RoleEnum::Instructor],
            ['name' => RoleEnum::Student],
        ]);
    }
}
