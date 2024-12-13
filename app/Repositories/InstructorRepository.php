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

    public function findById($id)
    {
        return Instructor::find($id);
    }

    public function findByEmail($email)
    {
        return Instructor::where('email', $email)->first();
    }

    public function createInstructor(array $data)
    {
        return Instructor::create($data);
    }

    public function updateInstructor(Instructor $instructor, array $data)
    {
        return $instructor->update($data);
    }

    public function deleteInstructor(Instructor $instructor)
    {
        return $instructor->delete();
    }
}
