<?php

namespace App\Repositories;

use App\Contracts\StudentRepositoryInterface;
use App\Models\Student;

class StudentRepository implements StudentRepositoryInterface
{
    public function findById($id)
    {
        // Eager load the 'user' relationship when finding a student by ID
        return Student::with('user')->find($id);
    }

    public function findByUuid($uuid)
    {
        return Student::where('uuid', $uuid)->first();
    }

    public function create(array $data)
    {
        return Student::create($data);
    }

    public function update(Student $student, array $data)
    {
        return $student->update($data);
    }

    public function findByDepartmentId($departmentId)
    {
        // Eager load the 'user' relationship when fetching students by department
        return Student::with('user')->where('department_id', $departmentId)->get();
    }

    public function count(): int
    {
        return Student::count();
    }
}
