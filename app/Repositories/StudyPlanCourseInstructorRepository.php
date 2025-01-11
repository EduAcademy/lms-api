<?php

namespace App\Repositories;

use App\Contracts\StudyPlanCourseInstructorRepositoryInterface;
use App\Models\StudyPlanCourseInstructor;

class StudyPlanCourseInstructorRepository implements StudyPlanCourseInstructorRepositoryInterface
{

    public function getAll()
    {
        $result = StudyPlanCourseInstructor::with('sp_course', 'group', 'instructor')->get();
        return $result;
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

}
