<?php

namespace App\Contracts;

interface AbsenceRepositoryInterface
{
    public function create(array $data, array $students);
    public function getAll();
    public function getAbsenceCountByStudentAndCourse($studentId, $courseId);
}
