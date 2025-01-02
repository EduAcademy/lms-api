<?php

namespace App\Contracts;

interface StudentRepositoryInterface
{
    public function findById($id);
    public function findByUuid($uuid);
    public function create(array $data);
    public function findByDepartmentId($departmentId);
}
