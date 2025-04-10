<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $departments = [

            [
                'name' => 'Information Technology',
                'short_name' => 'IT',
                'description' => 'Manages company technology and IT support.',
            ],
            [
                'name' => 'Marketing',
                'short_name' => 'MKT',
                'description' => 'Oversees advertising and promotional activities.',
            ],
            [
                'name' => 'Computer Science',
                'short_name' => 'CS',
                'description' => 'Focuses on the study of computer systems and computational processes.',
            ],
            [
                'name' => 'Software Engineering',
                'short_name' => 'SE',
                'description' => 'Centers on the application of engineering principles to software development.',
            ],
            [
                'name' => 'Artificial Intelligence',
                'short_name' => 'AI',
                'description' => 'Dedicated to the development of intelligent machines and systems.',
            ],
            [
                'name' => 'Cybersecurity',
                'short_name' => 'CYBER',
                'description' => 'Concentrates on protecting computer systems and networks from information disclosure, theft, or damage.',
            ],
            [
                'name' => 'Data Science',
                'short_name' => 'DS',
                'description' => 'Involves the extraction of knowledge and insights from structured and unstructured data.',
            ],
            [
                'name' => 'Human-Centered Computing',
                'short_name' => 'HCC',
                'description' => 'Studies the design, development, and deployment of computer technology focused on the human user.',
            ],
            [
                'name' => 'Graphics & Multimedia',
                'short_name' => 'GM',
                'description' => 'Focuses on visual design, animation, video production, and interactive media to create engaging digital content.',
            ],
            [
                'name' => 'Information Systems',
                'short_name' => 'IS',
                'description' => 'Combines business processes and technology to manage, analyze, and support organizational data and decision-making.',
            ]
            // Add more departments as needed
        ];

        foreach ($departments as $department) {
            DB::table('departments')->insert([
                'name' => $department['name'],
                'short_name' => $department['short_name'],
                'description' => $department['description'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
