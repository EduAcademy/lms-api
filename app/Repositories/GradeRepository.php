<?php

namespace App\Repositories;

use App\Contracts\GradeRepositoryInterface;
use App\Models\Grades;

class GradeRepository implements GradeRepositoryInterface
{

    public function getAll()
    {
        return Grades::all();
    }
    public function create(array $data)
    {
        return Grades::create($data);
    }

    public function getByInstructorId($instructorId)
    {
        return Grades::where('instructor_id', $instructorId)
            ->with(['course', 'group', 'student', 'subGroup']) // optional: eager load related models
            ->get();
    }

    public function getByStudentAndCourse($studentId, $courseId)
    {
        return Grades::where('student_id', $studentId)
            ->where('course_id', $courseId)
            ->with(['course', 'group', 'instructor', 'subGroup']) // optional
            ->get(); // or ->first() if you expect only one record
    }
}
