<?php

namespace App\Contracts;

interface StudentRepositoryInterface
{
    public function findById($id);
    public function findByEmail($email);
    public function getStudentsByDepartment($departmentId);
}
