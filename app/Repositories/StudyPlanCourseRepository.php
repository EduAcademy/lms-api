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

    public function create(array $data, array $courses)
    {
        $studyPlanCourseEntries = [];

        foreach ($courses as $course) {
            $studyPlanCourseEntries[] = [
                'study_plan_id' => $data['study_plan_id'],
                'department_id' => $data['department_id'],
                'semester' => $data['semester'],
                'level_id' => $data['level_id'],
                'course_id' => $course['course_id'],
            ];
        }

            return StudyPlanCourse::insert($studyPlanCourseEntries);
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
