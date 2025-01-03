<?php

namespace App\Repositories;

use App\Contracts\InstructorRepositoryInterface;
use App\Models\Instructor;

class InstructorRepository implements InstructorRepositoryInterface
{
    public function getAll()
    {
        return Instructor::all();
    }

    public function getById($id)
    {
        return Instructor::find($id);
    }

    public function create(array $data)
    {
        return Instructor::create($data);
    }
}
