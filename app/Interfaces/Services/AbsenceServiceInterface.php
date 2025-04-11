<?php

namespace App\Interfaces\Services;

interface AbsenceServiceInterface
{
    //
    public function createAbsence(array $data);
    public function getAllAbsence();
    public function getAbsenceCountByStudentAndCourse($studentId, $courseId);
}
