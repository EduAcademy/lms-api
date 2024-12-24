<?php

namespace App\Interfaces\Services;

interface LabGroupServiceInterface
{
    //
    public function getAllLabGroup();
    public function getLabById($id);
    public function createLabGroup(array $data);
    public function getLabByTheoGroup($theogroupId);
    public function getLabByInstructor($instructorId);
}
