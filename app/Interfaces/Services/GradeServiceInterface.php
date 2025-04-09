<?php

namespace App\Interfaces\Services;

interface GradeServiceInterface
{
    //
    public function getAll();
    public function create(array $data);
    public function getByInstructorId($instructorId);
    public function getByStudentAndCourse($studentId, $courseId);

}
