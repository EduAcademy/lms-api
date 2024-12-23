<?php

namespace App\Contracts;

interface StudyPlanRepositoryInterface
{
    //

    public function getAll();
    public function getById($id);
    public function getByDepartmentId($departmentId);
    public function getByCourseId($courseId);
    public function create(array $data, array $courses);
}
