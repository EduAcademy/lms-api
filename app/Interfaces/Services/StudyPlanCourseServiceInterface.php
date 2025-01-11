<?php

namespace App\Interfaces\Services;

interface StudyPlanCourseServiceInterface
{
    //
    public function getAllStudyPlanCourses();
    public function getStudyPlanCourseById($id);
    public function getStudyPlanCourseByStudyplanId($studyplanId);
    public function getStudyPlanCourseByDepartmentId($departmentId);
    public function getStudyPlanCourseByCourseId($courseId);
    public function createStudyPlanCourse(array $data);
    public function updateStudyPlanCourse($id, array $data);
    public function deleteStudyPlanCourse($id);

}
