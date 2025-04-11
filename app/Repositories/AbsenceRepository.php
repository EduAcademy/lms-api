<?php

namespace App\Repositories;

use App\Contracts\AbsenceRepositoryInterface;
use App\Models\Absence;
use Illuminate\Support\Facades\DB;

class AbsenceRepository implements AbsenceRepositoryInterface
{

    public function create(array $data, array $students)
    {
        $absenceEntries = [];

        foreach ($students as $student) {
            $absenceEntries[] = [
                'course_id' => $data['course_id'],
                'instructor_id' => $data['instructor_id'],
                'group_id' => $data['group_id'],
                'lecture_no' => $data['lecture_no'],
                'student_id' => $student['student_id'],
                'created_at' => now()
            ];
        }

        return Absence::insert($absenceEntries);
    }

    public function getAll()
    {
        return Absence::all();
    }

    public function getAbsenceCountByStudentAndCourse($studentId, $courseId)
    {
        return Absence::where('student_id', $studentId)
        ->where('course_id', $courseId)
        ->count();
    }
}
