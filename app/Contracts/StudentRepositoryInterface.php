<?php

namespace App\Contracts;

interface StudentRepositoryInterface
{
    public function findById($id);
    public function findByUuid($uuid);
    public function create(array $data);
    public function findByDepartmentId($departmentId);
    public function findByGroupId($groupId);
    public function findByUserId($userId);
    public function count(): int;
    public function getStudentsBySubGroupId($subgroupId);
}
