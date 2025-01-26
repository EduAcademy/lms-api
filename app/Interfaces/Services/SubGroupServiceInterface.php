<?php

namespace App\Interfaces\Services;

interface SubGroupServiceInterface
{
    //
    public function getAllSubGroups();
    public function getSubGroupById($id);
    public function getSubGroupByName($name);
    public function createSubGroup(array $data);
    public function getSubGroupByGroupId($groupId);
    public function getSubGroupByInstructorId($instructorId);
    public function updateSubGroup($id, array $data);
    public function deleteSubGroup($id);
}
