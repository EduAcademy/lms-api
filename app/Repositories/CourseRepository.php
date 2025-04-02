<?php

namespace App\Repositories;

use App\Contracts\CourseRepositoryInterface;
use App\Models\Course;

class CourseRepository implements CourseRepositoryInterface
{
    public function getAll()
    {
        $courses =  Course::all();

        return $courses;
    }

    public function create(array $data)
    {
        return Course::create($data);
    }

    public function getbyId($id)
    {
        return Course::find($id);
    }

    public function getCourses($instructorId, $departmentId, $levelId)
    {
        return Course::whereHas('sp_courses', fn($q) =>
        $q->where('department_id', $departmentId)
            ->where('level_id', $levelId)
            ->whereHas(
                'instructors',
                fn($q) =>
                $q->where('instructor_id', $instructorId)
            )
            ->get(['id', 'name']));
    }

    public function getbyDepartmentId($departmentId)
    {
        return Course::where('department_id', $departmentId)->first();
    }

    public function update($id, array $data) {}
    public function delete($id) {}
}
