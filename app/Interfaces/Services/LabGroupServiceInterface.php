<?php

namespace App\Interfaces\Services;

interface SubGroupserviceInterface
{
    //
    public function getAllLabGroup();
    public function getLabById($id);
    public function createLabGroup(array $data);
    public function getLabByTheoGroup($theogroupId);
    public function getLabByInstructor($instructorId);
    public function updateLabGroup($id, array $data);
    public function deleteLabGroup($id);
}
