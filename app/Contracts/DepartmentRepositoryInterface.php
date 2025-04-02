<?php

namespace App\Contracts;
use \App\Models\Department;
interface DepartmentRepositoryInterface
{
    //
    public function findById($id);
    public function findByShortName($shortName);
    public function create(array $data);
    public function getDepartmentByInstructorId($instructorId);
}
