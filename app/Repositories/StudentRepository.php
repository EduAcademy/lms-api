<?php

namespace App\Repositories;

use App\Contracts\StudentRepositoryInterface;
use App\Models\Student;

class StudentRepository implements StudentRepositoryInterface
{
    public function findById($id)
    {
        return Student::find($id);
    }

    public function findByEmail($email)
    {
        return Student::where('email', $email)->first();
    }

    public function getStudentsByDepartment($departmentId)
    {
        return Student::where('department_id', $departmentId)->get();
    }
}
