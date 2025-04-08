<?php

namespace App\Services;

use App\Contracts\NotificationRepositoryInterface;
use App\Interfaces\Services\NotificationServiceInterface;
use Illuminate\Support\Facades\Log;

class NotificationService implements NotificationServiceInterface
{
    protected $notificationRepo;
    private $roleService;

    public function __construct(NotificationRepositoryInterface  $notificationRepo, RoleService $roleService)
    {
        $this->notificationRepo = $notificationRepo;
        $this->roleService = $roleService;
    }



    public function notifyAllStudents($senderId, $content)
    {
        $userIds = $this->notificationRepo->getAllStudentUsers();
        Log::info($userIds);
        return $this->notificationRepo->createNotificationWithReceivers(
            ['sender_id' => $senderId, 'content' => $content],
            $userIds->toArray()
        );
    }

    public function sendToDepartment($senderId, $departmentId, $content)
    {
        $userIds = $this->notificationRepo->getDepartmentStudentUsers($departmentId);
        return $this->notificationRepo->createNotificationWithReceivers(
            ['sender_id' => $senderId, 'content' => $content],
            $userIds->toArray()
        );
    }

    public function sendToGroup($senderId, $groupId, $content)
    {
        $userIds = $this->notificationRepo->getGroupStudentUsers($groupId);
        return $this->notificationRepo->createNotificationWithReceivers(
            ['sender_id' => $senderId, 'content' => $content],
            $userIds->toArray()
        );
    }

    public function sendToSubGroup($senderId, $subGroupId, $content)
    {
        $userIds = $this->notificationRepo->getSubGroupStudentUsers($subGroupId);
        return $this->notificationRepo->createNotificationWithReceivers(
            ['sender_id' => $senderId, 'content' => $content],
            $userIds->toArray()
        );
    }

    public function sendToStudent($senderId, $studentId, $content)
    {
        $userId = $this->notificationRepo->getStudentUser($studentId);
        return $this->notificationRepo->createNotificationWithReceivers(
            ['sender_id' => $senderId, 'content' => $content],
            [$userId]
        );
    }
    public function getNotificationsByReceiverId($receiverId)
    {
        return $this->notificationRepo->getNotificationsByReceiverId($receiverId);
    }
}
