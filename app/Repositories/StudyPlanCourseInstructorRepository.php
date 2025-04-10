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

    public function getLevelsByInstructorAndCourse($instructorId, $courseId)
    {
        return StudyPlanCourseInstructor::where('instructor_id', $instructorId)
            ->whereHas('sp_course', function ($query) use ($courseId) {
                $query->where('course_id', $courseId);
            })
            ->with('sp_course:id,level_id')
            ->get()
            ->pluck('sp_course.level_id')
            ->unique()
            ->values();
    }

    public function getGroupByInstructorCourse($instructorId, $courseId, $levelId)
    {
        $groups = StudyPlanCourseInstructor::where('instructor_id', $instructorId)
            ->whereHas('sp_course', function ($query) use ($courseId, $levelId) {
                $query->where('course_id', $courseId)
                    ->where('level_id', $levelId);
            })
            ->with('group')
            ->get()
            ->map(function ($instructor) {
                return [
                    'group_id' => $instructor->group_id,
                    'group_name' => $instructor->group->name
                ];
            })
            ->unique('group_id')
            ->values();

        return $groups;
    }

    public function getCoursesByGroupId($groupId)
    {
        return StudyPlanCourseInstructor::where('group_id', $groupId)
            ->with('sp_course.course') // Load the course through sp_course
            ->get()
            ->map(function ($item) {
                return [
                    'group_id'   => $item->group_id,
                    'course_id'  => $item->sp_course->course->id ?? null,
                    'course_name' => $item->sp_course->course->name ?? null,
                ];
            })
            ->unique('course_id') // Optional: remove duplicates if needed
            ->values();
    }

    public function getInstructorsByGroupId($groupId)
    {
        $instructors = StudyPlanCourseInstructor::with('instructor')
            ->where('group_id', $groupId)
            ->get()
            ->pluck('instructor') // only get the instructor model
            ->unique('id')         // remove duplicates
            ->values();
        return $instructors;
    }
}
