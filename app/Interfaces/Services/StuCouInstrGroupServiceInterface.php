<?php

namespace App\Interfaces\Services;

interface StuCouInstrGroupServiceInterface
{
    //
    public function getAllStuCouInstrGroups();
    public function getStuCouInstrGroupById($id);
    public function getStuCouInstrGroupByCourseId($courseId);
    public function getStuCouInstrGroupByStudentId($studentId);
    public function getStuCouInstrGroupByInstructorId($instructorId);
    public function getStuCouInstrGroupByTheoGroupId($theogroupId);
    public function createStuCouInstrGroup(array $data);
    public function updateStuCouInstrGroup($id, array $data);
    public function deleteStuCouInstrGroup($id);

}
