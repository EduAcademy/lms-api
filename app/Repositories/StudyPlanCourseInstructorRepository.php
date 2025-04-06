<?php

namespace App\Repositories;

use App\Contracts\StudyPlanCourseInstructorRepositoryInterface;
use App\Models\StudyPlanCourseInstructor;
use Illuminate\Support\Facades\DB;

class StudyPlanCourseInstructorRepository implements StudyPlanCourseInstructorRepositoryInterface
{

    public function getAll()
    {
        $result = StudyPlanCourseInstructor::with('sp_course', 'group', 'instructor')->get();
        return $result;
    }

    public function getinstcourses($instId)
    {

        StudyPlanCourseInstructor::with('instructor', $instId)->get();
    }

    public function getById($id)
    {
        $result = StudyPlanCourseInstructor::find($id);
        return $result;
    }

    public function create(array $data)
    {
        return StudyPlanCourseInstructor::create($data);
    }

    public function getByStudyplanCourseId($stupCId)
    {
        $result = StudyPlanCourseInstructor::with('sp_course', $stupCId)->get();
        return $result;
    }

    public function getByGroupId($groupId)
    {
        $result = StudyPlanCourseInstructor::with('group', $groupId)->get();
        return $result;
    }

    public function getByInstructorId($instructorId)
    {
        $result = StudyPlanCourseInstructor::with('instructor', $instructorId)->get();
        return $result;
    }

    public function getDepartmentsByInstructorId($instructorId)
    {
        $data = StudyPlanCourseInstructor::with('sp_course.department')
            ->where('instructor_id', $instructorId)
            ->get()
            ->map(function ($item) {
                return [
                    'department_id' => $item->sp_course->department_id ?? null,
                    'department_name' => $item->sp_course->department->name ?? null,
                    'instructor_id' => $item->instructor_id,
                ];
            });
        return $data;
    }
}
