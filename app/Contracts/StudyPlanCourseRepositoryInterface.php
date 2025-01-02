<?php

namespace App\Contracts\Contracts;

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
