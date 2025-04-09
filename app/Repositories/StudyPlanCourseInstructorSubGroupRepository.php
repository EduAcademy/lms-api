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

    public function getCoursesBySubGroupId($subGroupId)
    {
        return StudyPlanCourseInstructorSubGroup::where('sub_group_id', $subGroupId)
            ->with('studyPlanCourseInstructor.sp_course.course') // nested relationship
            ->get()
            ->pluck('studyPlanCourseInstructor.sp_course.course') // get course directly
            ->unique('id') // ensure no duplicates
            ->values();
    }

    public function getSubGroupsByCourseLevel($courseId, $levelId)
    {
        return StudyPlanCourseInstructorSubGroup::whereHas('studyPlanCourseInstructor', function ($q) use ($courseId, $levelId) {
            $q->whereHas('sp_course', function ($q2) use ($courseId, $levelId) {
                $q2->where('course_id', $courseId)
                    ->where('level_id', $levelId);
            });
        })
            ->with('subGroup:id,id,name') // eager load the subgroup
            ->get()
            ->pluck('subGroup') // extract only the subGroup model
            ->unique('id') // remove duplicates
            ->values(); // reset keys
    }
}
