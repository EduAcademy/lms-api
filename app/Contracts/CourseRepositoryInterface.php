<?php

namespace App\Contracts;

interface CourseRepositoryInterface
{
    //
    public function getAll();
    public function getbyId($id);
    public function getbyDepartmentId($departmentId);
    public function create(array $data);
    public function update($id, array $data);
    public function delete($id);
}
