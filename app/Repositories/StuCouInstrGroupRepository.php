<?php

namespace App\Repositories;

use App\Contracts\StuCouInstrGroupRepositoryInterface;
use App\Models\StudentCourseInstructorGroup;

class StuCouInstrGroupRepository implements StuCouInstrGroupRepositoryInterface
{
    public function getAll()
    {
        return StudentCourseInstructorGroup::all();
    }

    public function getById($id)
    {
        $result = StudentCourseInstructorGroup::find($id);
        return $result;
    }

    public function getByCourseId($courseId)
    {
        $result = StudentCourseInstructorGroup::with('course')->get();
        return $result;
    }

    public function getByStudentId($studentId)
    {
        $result = StudentCourseInstructorGroup::with('student')->get();
        return $result;
    }

    public function getByInstructorId($instructorId)
    {
        $result = StudentCourseInstructorGroup::with('instructor')->get();
        return $result;
    }

    public function getByTheoGroupId($theogroupId)
    {
        $result = StudentCourseInstructorGroup::with('theoreticalGroup')->get();
        return $result;
    }

    public function create(array $data)
    {
        $result = StudentCourseInstructorGroup::create($data);
        return $result;
    }

}
