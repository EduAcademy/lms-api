<?php

namespace App\Contracts;

use App\Models\Instructor;

interface InstructorRepositoryInterface
{
    public function getAll();
    public function findById($id);
    public function create(array $data);
}
