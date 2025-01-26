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
}
