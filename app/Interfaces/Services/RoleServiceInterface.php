<?php

namespace App\Interfaces\Services;

interface RoleServiceInterface
{
    //
    public function getAllRoles();
    public function getRoleByName($name);
}
