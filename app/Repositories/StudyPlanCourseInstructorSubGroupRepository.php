<?php

namespace App\Repositories;

use App\Contracts\StudyPlanCourseInstructorSubGroupRepositoryInterface;
use App\Models\StudyPlanCourseInstructorSubGroup;

class StudyPlanCourseInstructorSubGroupRepository implements StudyPlanCourseInstructorSubGroupRepositoryInterface
{
    public function getAll()
    {
        $result = StudyPlanCourseInstructorSubGroup::with('studyPlanCourseInstructor', 'subGroup', 'instructor')->get();
        return $result;
    }

    public function getById($id)
    {
        $result = StudyPlanCourseInstructorSubGroup::find($id);
        return $result;
    }

    public function create(array $data)
    {
        return StudyPlanCourseInstructorSubGroup::create($data);
    }

    public function getByStudyplanCourseInstructorId($stupCInsId)
    {
        $result = StudyPlanCourseInstructorSubGroup::with('studyPlanCourseInstructor', $stupCInsId)->get();
        return $result;
    }

    public function getBySubgroupId($sub_groupId)
    {
        $result = StudyPlanCourseInstructorSubGroup::with('subGroup', $sub_groupId)->get();
        return $result;
    }

    public function getByInstructorId($instructorId)
    {
        $result = StudyPlanCourseInstructorSubGroup::with('instructor', $instructorId)->get();
        return $result;
    }

}
