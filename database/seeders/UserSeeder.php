<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $chunks = 100; // Insert rows in chunks
        $total = 100; // Total rows

        for ($i = 0; $i < $total / $chunks; $i++) {
            User::factory()->count($chunks)->create();
        }
    }
}
