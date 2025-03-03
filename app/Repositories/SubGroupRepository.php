<?php

namespace App\Repositories;

use App\Contracts\SubGroupRepositoryInterface;
use App\Models\SubGroups;

class SubGroupRepository implements SubGroupRepositoryInterface
{
    public function getAll()
    {
        return SubGroups::all();
    }

    public function getById($id)
    {
        $result = SubGroups::find($id);
        return $result;
    }

    public function getByName($name)
    {
        $result = SubGroups::where('name', $name)->first();
        return $result;
    }

    public function getByGroupId($theogroupId)
    {
        $result = SubGroups::with('group')->get();
        return $result;
    }

    public function getByInstructorId($instructorId)
    {
        $result = SubGroups::with('instructor')->get();
        return $result;
    }


    public function create(array $data)
    {
        $result = SubGroups::create($data);
        return $result;
    }
}
