<?php

namespace App\Contracts\Contracts;

interface StudyPlanCourseInstructorSubGroupRepositoryInterface
{
    //
    public function getAll();
    public function getById($id);
    public function create(array $data);
    public function getByStudyplanCourseId($stupCId);
    public function getBySubgroupId($sub_groupId);
    public function getByInstructorId($instructorId);
}
