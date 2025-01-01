<?php

namespace App\Repositories;

use App\Contracts\TheoreticalGroupRepositoryInterface;
use App\Models\Groups;

class TheoreticalGroupRepository implements TheoreticalGroupRepositoryInterface
{
    public function getAll()
    {
        return Groups::all();
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
}
