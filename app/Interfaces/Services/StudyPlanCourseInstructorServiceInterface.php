<?php

namespace App\Interfaces\Services;

interface StudyPlanCourseInstructorServiceInterface
{
    //
    public function getAllSpCInstructors();
    public function getSpCInstructorById($id);
    public function createSpCInstructor(array $data);
    public function getSpCInstructorBySpCourseId($stupCId);
    public function getSpCInstructorByGroupId($groupId);
    public function getSpCInstructorByInstruId($instructorId);
    public function updateSpCInstructor($id, array $data);
    public function deleteSpCInstructor($id);
    public function getDepartmentsByInstructorId($instructorId);
}
