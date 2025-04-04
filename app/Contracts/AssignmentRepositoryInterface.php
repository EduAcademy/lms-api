<?php

namespace App\Contracts;

interface AssignmentRepositoryInterface
{
    //
    public function getAll();
    public function getById($id);
    public function create(array $data);
    public function update($id, array $data);
    public function delete($id);
    public function getbyInstructorId($instructorId);
    public function getbyGroupId($groupId);

}
