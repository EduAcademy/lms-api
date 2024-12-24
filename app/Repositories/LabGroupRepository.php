<?php

namespace App\Repositories;

use App\Contracts\LabGroupRepositoryInterface;
use App\Models\LabGroups;

class LabGroupRepository implements LabGroupRepositoryInterface
{
    public function getAll()
    {
        return LabGroups::all();
    }

    public function getById($id)
    {
        $result = LabGroups::find($id);
        return $result;
    }

    public function getByTheoGroupId($theogroupId)
    {
        $result = LabGroups::with('theoretical_group')->get();
        return $result;
    }

    public function getByInstructorId($instructorId)
    {
        $result = LabGroups::with('instructor')->get();
        return $result;
    }

    public function create(array $data)
    {
        $result = LabGroups::create($data);
        return $result;
    }

}
