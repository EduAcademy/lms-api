<?php

namespace App\Contracts;

interface StudyPlanCourseInstructorSubGroupRepositoryInterface
{
    //
    public function getAll();
    public function getById($id);
    public function create(array $data);
    public function getByStudyplanCourseInstructorId($stupCInsId);
    public function getBySubgroupId($sub_groupId);
    public function getByInstructorId($instructorId);
}
