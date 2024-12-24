<?php

namespace App\Contracts;

interface LabGroupRepositoryInterface
{
    //
    public function getAll();
    public function getById($id);
    public function getByTheoGroupId($theogroupId);
    public function getByInstructorId($instructorId);
    public function create(array $data);
}
