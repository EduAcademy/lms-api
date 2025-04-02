<?php

namespace App\Repositories;

use App\Contracts\GroupRepositoryInterface;
use App\Models\Groups;

class GroupRepository implements GroupRepositoryInterface
{
    public function getAll()
    {
        return Groups::all();
    }

    public function getByName($name)
    {
        $result = Groups::where('name', $name)->first();
        return $result;
    }

    public function getById($id)
    {
        $result = Groups::find($id);
        return $result;
    }

    public function create(array $data)
    {
        $result = Groups::create($data);
        return $result;
    }
    public function getGroups($instructorId, $departmentId, $levelId, $courseId)
    {
        return Groups::whereHas('spc_instructors', fn($q) =>
        $q->where('instructor_id', $instructorId)
            ->whereHas(
                'sp_course',
                fn($q) =>
                $q->where('department_id', $departmentId)
                    ->where('level_id', $levelId)
                    ->where('course_id', $courseId)
            )
            ->get(['id', 'name']));
    }
}
