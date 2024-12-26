<?php

namespace App\Interfaces\Services;

interface CourseMaterialServiceInterface
{
    //
    public function getAllCourseMaterials();
    public function getCourseMaterialById($id);
    public function getCourseMaterialByCourseId($courseId);
    public function getCourseMaterialByInstructorId($instructorId);
    public function createCourseMaterial(array $data);
    public function updateCourseMaterial($id, array $data);
    public function deleteCourseMaterial($id);
}
