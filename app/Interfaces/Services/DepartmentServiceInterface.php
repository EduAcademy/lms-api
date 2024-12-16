<?php

namespace App\Interfaces\Services;

use App\Models\Department;

interface DepartmentServiceInterface {
    public function getAllDepartments();
    public function getDepartmentById($id);
    public function getDepartmentByShortName($shortName);
    public function createDepartment(array $data);
    public function updateDepartment($id, array $data);
    public function deleteDepartment($id);
}
