<?php

namespace App\Contracts;

interface CourseMaterialRepositoryInterface
{
    //
    public function getAll();
    public function getById($id);
    public function getByInstructorId($instructorId);
    public function getByCourseId($courseId);
    public function create(array $data);
}
