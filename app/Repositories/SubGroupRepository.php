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

    public function getByTheoGroupId($theogroupId)
    {
        $result = SubGroups::with('theoretical_group')->get();
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
