<?php

namespace App\Interfaces\Services;

interface AssignmentServiceInterface
{
    //
    public function getAllAssignment();
    public function getAssignmentById($id);
    public function createAssignment(array $data);
    public function updateAssignment($id, array $data);
    public function deleteAssignment($id);
    public function getbyInstructorId($instructorId);
    public function getbyGroupId($groupId);
    public function getbySubGroupId($subGroupId);
}
