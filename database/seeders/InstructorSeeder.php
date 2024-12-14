<?php

namespace Database\Seeders;

use App\Models\Instructor;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InstructorSeeder extends Seeder
{
    /*************  ✨ Codeium Command 🌟  *************/
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $chunks = 50; // Insert rows in chunks
        $total = 50; // Total rows

        for ($i = 0; $i < $total / $chunks; $i++) {
            Instructor::factory()->count($chunks)->create(['user_id' => rand(1, User::count())]);
        }
    }
    /******  8f83adad-3b0f-4ef1-a85c-8b6ba26bdcfb  *******/
}
