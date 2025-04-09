<?php

namespace App\Contracts;

interface GradeRepositoryInterface
{
    //
    public function getAll();
    public function create(array $data);
    public function getByInstructorId($instructorId);
    public function getByStudentAndCourse($studentId, $courseId);
}
