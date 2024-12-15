<?php

namespace App\Contracts;

interface DepartmentRepositoryInterface
{
    //
    public function findById($id);
    public function findByShortName($shortName);
    public function create(array $data);
    public function update(\App\Models\Department $department, array $data);
}
