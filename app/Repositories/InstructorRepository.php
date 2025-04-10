<?php

namespace App\Repositories;

use App\Contracts\InstructorRepositoryInterface;
use App\Models\Instructor;

class InstructorRepository implements InstructorRepositoryInterface
{
    public function getAll()
    {
        return Instructor::with('user')->get();
    }

    public function getById($id)
    {
        return Instructor::find($id);
    }

    public function create(array $data)
    {
        return Instructor::create($data);
    }

    public function count(): int
    {
        return Instructor::count();
    }
    public function findByUserId($userId)
    {
        // Eager load the 'user' relationship when fetching students by department
        return Instructor::where('user_id', $userId)->get();
    }
}
