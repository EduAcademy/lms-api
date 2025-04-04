<?php

namespace App\Repositories;

use App\Contracts\AssignmentRepositoryInterface;
use App\Models\Assignment;

class AssignmentRepository implements AssignmentRepositoryInterface
{
    public function getAll()
    {
        $assignments = Assignment::with([
            'group',
            'subGroup',
            'studyPlanCourse'
        ])
            ->get()
            ->map(function ($assignment) {
                return [
                    "id" => $assignment->id,
                    "title" => $assignment->title,
                    "instructions" => $assignment->instructions,
                    "due_date" => $assignment->due_date,
                    "InstructorId" => $assignment->instructor_id,
                    "study_plan_course_instructor_id" => $assignment->study_plan_course_instructor_id,
                    "study_plan_course_instructor_sub_group_id" => $assignment->study_plan_course_instructor_sub_group_id,
                    "GroupId" => optional($assignment->group)->id,
                    "GroupName" => optional($assignment->group)->name,
                    "SubGroupId" => optional($assignment->subGroup)->id,
                    "SubGroupName" => optional($assignment->subGroup)->name,
                    "CourseId" => optional($assignment->studyPlanCourse->course)->id,
                    "CourseName" => optional($assignment->studyPlanCourse->course)->name,
                    "DepartmentId" => optional($assignment->studyPlanCourse->Department)->id,
                    "DepartmentName" => optional($assignment->studyPlanCourse->Department)->name,
                    "LevelId" => optional($assignment->studyPlanCourse->Level)->id,
                    "LeveltName" => optional($assignment->studyPlanCourse->Level)->name,
                    "SemesterId" => optional($assignment->studyPlanCourse)->semester,
                    "SemesterName" => 'Semester' . optional($assignment->studyPlanCourse)->semester

                ];
            });


        return $assignments->values()->toArray();
    }


    public function getbyId($id)
    {
        return Assignment::find($id);
    }


    public function create(array $data)
    {
        return Assignment::create($data);
    }

    public function update($id, array $data)
    {

        $assignment = Assignment::find($id);
        if ($assignment) {
            $assignment->update($data);
            return $assignment;
        }
        return null;
    }
    public function delete($id)
    {
        $assignment = Assignment::find($id);
        if ($assignment) {
            $assignment->delete();
            return true;
        }
        return false;
    }
    public function getbyInstructorId($instructorId)
    {
        $assignments = Assignment::with([
            'group',
            'subGroup',
            'studyPlanCourse'
        ])
            ->where('instructor_id', $instructorId)
            ->get()
            ->map(function ($assignment) {
                return [
                    "id" => $assignment->id,
                    "title" => $assignment->title,
                    "instructions" => $assignment->instructions,
                    "due_date" => $assignment->due_date,
                    "InstructorId" => $assignment->instructor_id,
                    "study_plan_course_instructor_id" => $assignment->study_plan_course_instructor_id,
                    "study_plan_course_instructor_sub_group_id" => $assignment->study_plan_course_instructor_sub_group_id,
                    "GroupId" => optional($assignment->group)->id,
                    "GroupName" => optional($assignment->group)->name,
                    "SubGroupId" => optional($assignment->subGroup)->id,
                    "SubGroupName" => optional($assignment->subGroup)->name,
                    "CourseId" => optional($assignment->studyPlanCourse->course)->id,
                    "CourseName" => optional($assignment->studyPlanCourse->course)->name,
                    "DepartmentId" => optional($assignment->studyPlanCourse->Department)->id,
                    "DepartmentName" => optional($assignment->studyPlanCourse->Department)->name,
                    "LevelId" => optional($assignment->studyPlanCourse->Level)->id,
                    "LeveltName" => optional($assignment->studyPlanCourse->Level)->name,
                    "SemesterId" => optional($assignment->studyPlanCourse)->semester,
                    "SemesterName" => 'Semester' . optional($assignment->studyPlanCourse)->semester

                ];
            });


        return $assignments->values()->toArray();
    }
    public function getbyGroupId($groupId)
    {
        $assignments = Assignment::with([
            'group',
            'subGroup',
            'studyPlanCourse'
        ])
            ->whereHas('group', function ($query) use ($groupId) {
                $query->where('group_id', $groupId);
            })
            ->get()
            ->map(function ($assignment) {
                return [
                    "id" => $assignment->id,
                    "title" => $assignment->title,
                    "instructions" => $assignment->instructions,
                    "due_date" => $assignment->due_date,
                    "InstructorId" => $assignment->instructor_id,
                    "study_plan_course_instructor_id" => $assignment->study_plan_course_instructor_id,
                    "study_plan_course_instructor_sub_group_id" => $assignment->study_plan_course_instructor_sub_group_id,
                    "GroupId" => optional($assignment->group)->id,
                    "GroupName" => optional($assignment->group)->name,
                    "SubGroupId" => optional($assignment->subGroup)->id,
                    "SubGroupName" => optional($assignment->subGroup)->name,
                    "CourseId" => optional($assignment->studyPlanCourse->course)->id,
                    "CourseName" => optional($assignment->studyPlanCourse->course)->name,
                    "DepartmentId" => optional($assignment->studyPlanCourse->Department)->id,
                    "DepartmentName" => optional($assignment->studyPlanCourse->Department)->name,
                    "LevelId" => optional($assignment->studyPlanCourse->Level)->id,
                    "LeveltName" => optional($assignment->studyPlanCourse->Level)->name,
                    "SemesterId" => optional($assignment->studyPlanCourse)->semester,
                    "SemesterName" => 'Semester' . optional($assignment->studyPlanCourse)->semester

                ];
            });


        return $assignments->values()->toArray();
    }
}
