<?php

namespace App\Interfaces\Services;

use App\Models\Department;

interface DepartmentServiceInterface {
    public function getDepartmentById($id);
    public function getDepartmentByShortName($shortName);
    public function createDepartment(array $data);
    public function updateDepartment(Department $department, array $data);
}