<?php

namespace App\Interfaces\Services;

interface StudyPlanCourseInstructorSubGroupServiceInterface
{
    //

    public function getAllSpCInstSubGrou();
    public function getSpCInstSubGrouById($id);
    public function createSpCInstSubGrou(array $data);
    public function getSpCInstSubGrouBySpCInstId($stupCInsId);
    public function getSpCInstSubGrouBySubgroupId($sub_groupId);
    public function getSpCInstSubGrouByInstrId($instructorId);
    public function updateSpCInstSubGrou($id, array $data);
    public function deleteSpCInstSubGrou($id);
    public function getCoursesBySubGroupId($subGroupId);
}
