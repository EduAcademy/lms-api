<?php

namespace App\Contracts;

interface StudyPlanCourseRepositoryInterface
{
    //
    public function getAll();
    public function getById($id);
    public function create(array $data);
    public function getByStudyplanId($studyplanId);
    public function getByDepartmentId($departmentId);
    public function getByCourseId($courseId);
}
