<?php

namespace App\Repositories;

use App\Contracts\StudyPlanCourseRepositoryInterface;
use App\Models\StudyPlanCourse;

class StudyPlanCourseRepository implements StudyPlanCourseRepositoryInterface
{
    public function getAll()
    {
        $result = StudyPlanCourse::with('studyPlan', 'department', 'course', 'level')->get();
        return $result;
    }

    public function getById($id)
    {
        $result = StudyPlanCourse::find($id);
        return $result;
    }

    public function create(array $data)
    {
        return StudyPlanCourse::create($data);
    }

    public function getByStudyplanId($studyplanId)
    {
        $result = StudyPlanCourse::with('studyPlan', $studyplanId)->get();
        return $result;
    }

    public function getByDepartmentId($departmentId)
    {
        $result = StudyPlanCourse::with('department', $departmentId)->get();
        return $result;
    }

    public function getByCourseId($courseId)
    {
        $result = StudyPlanCourse::with('course', $courseId)->get();
        return $result;
    }

}
