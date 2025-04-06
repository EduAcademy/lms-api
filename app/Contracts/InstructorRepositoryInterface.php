<?php

namespace App\Contracts;

use App\Models\Instructor;

interface InstructorRepositoryInterface
{
    public function getAll();
    public function getById($id);
    public function create(array $data);
    public function count(): int;
    
}
