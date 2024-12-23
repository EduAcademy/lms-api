<?php

namespace App\Repositories;

use App\Contracts\StudentRepositoryInterface;
use App\Contracts\StudyPlanRepositoryInterface;
use App\Models\StudyPlan;

class StudyPlanRepository Implements StudyPlanRepositoryInterface
{

    public function getAll()
    {
        $studyplans = StudyPlan::all();

        return $studyplans;
    }

    public function getByDepartmentId($departmentId)
    {
        $studyplans =  StudyPlan::with('department')->get();

        return $studyplans;
    }

    public function getById($id)
    {
        $studyplan = StudyPlan::find($id);
    }

    public function getByCourseId($courseId)
    {
        $studyplans = StudyPlan::with('course')->get();

        return $studyplans;
    }

    public function create(array $data, array $courses)
    {
        $studyPlanEntries = [];

        foreach ($courses as $course) {
            $studyPlanEntries[] = [
                'study_plan_no' => $data['study_plan_no'],
                'level' => $data['level'],
                'semester' => $data['semester'],
                'issued_at' => $data['issued_at'],
                'department_id' => $data['department_id'], // Department from course
                'course_id' => $course['course_id'],         // Course ID
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        return StudyPlan::insert($studyPlanEntries); // Bulk insert into the database
    }

}
