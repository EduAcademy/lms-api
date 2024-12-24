<?php

namespace App\Contracts;

interface StuCouInstrGroupRepositoryInterface
{
    //
    public function getAll();
    public function getById($id);
    public function getByCourseId($courseId);
    public function getByStudentId($studentId);
    public function getByInstructorId($instructorId);
    public function getByTheoGroupId($theogroupId);
    public function create(array $data);
}
