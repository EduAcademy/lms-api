<?php

namespace App\Repositories;

use App\Contracts\TheoreticalGroupRepositoryInterface;
use App\Models\TheoreticalGroups;

class TheoreticalGroupRepository implements TheoreticalGroupRepositoryInterface
{
    public function getAll()
    {
        return TheoreticalGroups::all();
    }

    public function getById($id)
    {
        $result = TheoreticalGroups::find($id);
        return $result;
    }

    public function create(array $data)
    {
        $result = TheoreticalGroups::create($data);
        return $result;
    }

}
