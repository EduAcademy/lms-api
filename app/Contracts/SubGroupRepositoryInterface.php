<?php

namespace App\Contracts;

interface SubGroupRepositoryInterface
{
    //
    public function getAll();
    public function getById($id);
    public function getByName($name);
    public function getByGroupId($theogroupId);
    public function getByInstructorId($instructorId);
    public function create(array $data);
}
