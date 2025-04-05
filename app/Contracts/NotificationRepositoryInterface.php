<?php

namespace App\Contracts;

interface NotificationRepositoryInterface
{
    public function createNotificationWithReceivers(array $notificationData, array $userIds);
    public function getAllStudentUsers();
    public function getDepartmentStudentUsers($departmentId);
    public function getGroupStudentUsers($groupId);
    public function getStudentUser($studentId);
    public function getNotificationsByReceiverId($receiverId);
}
