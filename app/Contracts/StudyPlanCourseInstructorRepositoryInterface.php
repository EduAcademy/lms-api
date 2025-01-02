<?php

namespace App\Contracts\Contracts;

interface StudyPlanCourseInstructorRepositoryInterface
{
    //
    public function getAll();
    public function getById($id);
    public function create(array $data);
    public function getByStudyplanCourseId($stupCId);
    public function getByGroupId($groupId);
    public function getByInstructorId($instructorId);
}
