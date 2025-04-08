<?php

namespace App\Repositories;

use App\Contracts\StudyPlanCourseRepositoryInterface;
use App\Models\StudyPlanCourse;
use Illuminate\Support\Facades\Log;

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
    public function getSemesterByLevelId($levelId)
    {
        $data = StudyPlanCourse::whereHas('level', function ($query) use ($levelId) {
            $query->where('id', "=", $levelId);
        })
            ->with('level')
            ->selectRaw('level_id, semester')
            ->groupBy('level_id', 'semester')
            ->get()
            ->map(function ($spc) {
                return [
                    'id' => $spc->semester,
                    'name' => 'Semester ' . $spc->semester
                ];
            });

        return $data;
    }
    public function getCoursBySemesterId($department_id, $level_id, $semester)
    {
        $data = StudyPlanCourse::with(['department', 'level', 'course'])
            ->where('department_id', $department_id)
            ->where('level_id', $level_id)
            ->when($semester != 0, function ($query) use ($semester) {
                return $query->where('semester', $semester);
            })
            ->get()
            ->map(function ($spc) {
                return [
                    'id' => $spc->course->id,
                    'name' => $spc->course->name
                ];
            });

        return $data;
    }
    public function getCourseByInstructorId($department_id, $level_id, $semester, $instructorId)
    {
        $data = StudyPlanCourse::with(['course', 'instructors.instructor'])
            ->where('department_id', $department_id)
            ->where('level_id', $level_id)
            ->where('semester', $semester)
            ->whereHas('instructors.instructor', function ($query) use ($instructorId) {
                $query->where('instructor_id', $instructorId);
            })
            ->get()
            ->map(function ($spc) {
                return [
                    'id' => $spc->course->id,
                    'name' => $spc->course->name
                ];
            });

        return $data;
    }


    public function getCourseByGroupId($department_id, $level_id, $semester, $groupId)
    {
        $data = StudyPlanCourse::with(['course', 'instructors.group'])
            ->where('department_id', $department_id)
            ->where('level_id', $level_id)
            ->where('semester', $semester)
            ->whereHas('instructors.group', function ($query) use ($groupId) {
                $query->where('instructor_id', $groupId);
            })
            ->get()
            ->map(function ($spc) {
                return [
                    'id' => $spc->course->id,
                    'name' => $spc->course->name
                ];
            });

        return $data;
    }

    public function getGroupByCourseid($department_id, $level_id, $semesterId, $courseid)
    {
        $data = StudyPlanCourse::with(['instructors.group'])
            ->where('department_id', $department_id)
            ->where('level_id', $level_id)
            ->where('semester', $semesterId)
            ->where('course_id', $courseid)
            ->get()
            ->flatMap(function ($spc) {
                return $spc->instructors->map(function ($instructor) {
                    return [
                        'studyPlanCourseInstructorId' => $instructor->id,
                        'id' => $instructor->group->id ?? null,
                        'name' => $instructor->group->name ?? null,
                    ];
                });
            })
            ->filter(fn($group) => $group['id'] !== null)
            ->unique('id')
            ->values();

        return $data;
    }
    public function getSubGroupByGroupid($department_id, $level_id, $semesterId, $courseid, $groupid)
    {
        $data = StudyPlanCourse::with(['instructors' => function ($query) use ($groupid) {
            $query->where('group_id', $groupid)
                ->with(['spci_sub_groups.subGroup']);
        }])
            ->where('department_id', $department_id)
            ->where('level_id', $level_id)
            ->where('semester', $semesterId)
            ->where('course_id', $courseid)
            ->get()
            ->flatMap(function ($spc) {
                return $spc->instructors
                    ->flatMap(function ($instructor) {
                        return $instructor->spci_sub_groups->map(function ($subGroupRelation) {
                            return [
                                'studyPlanCourseInstructorSubGroupId' => $subGroupRelation->id,
                                'id' => $subGroupRelation->subGroup->id ?? null,
                                'name' => $subGroupRelation->subGroup->name ?? null,
                            ];
                        });
                    });
            })
            ->filter(fn($item) => $item['id'] !== null)
            ->unique('id')
            ->values();

        return $data;
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

    public function getCoursesByInstructor($instructorId)
    {
        $courses = StudyPlanCourse::whereHas('instructors', function ($query) use ($instructorId) {
            $query->where('instructor_id', $instructorId);
        })
            ->with('course')
            ->get()
            ->map(function ($spc) {
                return [
                    'course_id' => $spc->course_id,
                    'name' => $spc->course->name
                ];
            });
        return $courses;
    }
}
