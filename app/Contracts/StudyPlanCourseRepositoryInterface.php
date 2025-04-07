<?php

namespace App\Contracts;

interface StudyPlanCourseRepositoryInterface
{
    //
    public function getAll();
    public function getById($id);
    public function create(array $data, array $courses);
    public function getByStudyplanId($studyplanId);
    public function getByDepartmentId($departmentId);
    public function getByCourseId($courseId);
    public function getSemesterByLevelId($levelId);
    public function getCoursBySemesterId($department_id, $level_id, $semester);
    public function getGroupByCourseid($department_id, $level_id, $semesterId, $courseid);
    public function getSubGroupByGroupid($department_id, $level_id, $semesterId, $courseid, $groupid);
    public function getCourseByInstructorId($department_id, $level_id, $semester, $instructorId);
    public function getCourseByGroupId($department_id, $level_id, $semester, $groupId);
}
