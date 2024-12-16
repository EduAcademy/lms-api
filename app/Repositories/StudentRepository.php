<?php

namespace App\Repositories;

use App\Models\Student;
use App\Contracts\StudentRepositoryInterface;

class StudentRepository implements StudentRepositoryInterface
{
    public function findById($id)
    {
        return Student::find($id);
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
        return Student::where('department_id', $departmentId)->get();
    }
}
