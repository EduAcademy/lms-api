<?php

namespace App\Interfaces\Services;

interface NotificationServiceInterface
{

    public function notifyAllStudents($senderId, $content);
    public function sendToDepartment($senderId, $departmentId, $content);
    public function sendToGroup($senderId, $groupId, $content);
    public function sendToStudent($senderId, $studentId, $content);
    public function getNotificationsByReceiverId($receiverId);
    public function sendToSubGroup($senderId, $subGroupId, $content);
}
