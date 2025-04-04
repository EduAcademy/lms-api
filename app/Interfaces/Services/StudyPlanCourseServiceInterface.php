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
    public function getSemesterByLevelId($levelId);
    public function getCoursBySemesterId($department_id, $level_id, $semester);
    public function getGroupByCourseid($department_id, $level_id, $semesterId, $courseid);
    public function getSubGroupByGroupid($department_id, $level_id, $semesterId, $courseid, $groupid);
    public function getCourseByInstructorId($department_id, $level_id, $semester, $instructorId);
}
