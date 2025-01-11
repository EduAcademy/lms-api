<?php

namespace App\Services;

use App\Interfaces\Services\RoleServiceInterface;
use App\Models\Role;

class RoleService implements RoleServiceInterface
{
    public function getAllRoles()
    {
        $result = Role::all();

        return $result;
    }

    public function getRoleByName($name)
    {
        $result = Role::where('name', $name)->value('id');

        return $result;
    }
}
