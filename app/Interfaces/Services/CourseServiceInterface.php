<?php

namespace App\Interfaces\Services;

interface CourseServiceInterface
{
    public function getAllCourses();
    public function getCourseById($id);
    public function getCourseByDepartmentId($departmentId);
    public function createCourse(array $data);
    public function updateCourse($id, array $data);
    public function deleteCourse($id);
}
