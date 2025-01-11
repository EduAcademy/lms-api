<?php

namespace App\Interfaces\Services;

interface SubGroupserviceInterface
{
    //
    public function getAllSubGroups();
    public function getSubGroupById($id);
    public function createSubGroup(array $data);
    public function getSubByTheoGroup($theogroupId);
    public function getSubByInstructor($instructorId);
    public function updateSubGroup($id, array $data);
    public function deleteSubGroup($id);
}
