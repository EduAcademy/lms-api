<?php

namespace App\Repositories;

use App\Contracts\NotificationRepositoryInterface;
use App\Models\Instructor;
use App\Models\Notification;
use App\Models\NotificationReceiver;
use App\Models\Student;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class NotificationRepository implements NotificationRepositoryInterface
{

    public function getAllStudentUsers()
    {
        return User::whereHas('student')->pluck('id');
    }

    public function createNotificationWithReceivers(array $notificationData, array $userIds)
    {
        $notification = Notification::create($notificationData);

        $receivers = array_map(function($userId) use ($notification) {
            return [
                'notification_id' => $notification->id,
                'receiver_id' => $userId,
                'created_at' => now(),
                'updated_at' => now()
            ];
        }, $userIds);
        Log::debug('data coming from the repository : ' ,$receivers);
        Log::info('data coming from the repository : ' , $receivers);
        NotificationReceiver::insert($receivers);

        return $notification;
    }

    public function getDepartmentStudentUsers($departmentId)
    {
        return User::whereHas('student', function($query) use ($departmentId) {
            $query->where('department_id', $departmentId);
        })->pluck('id');
    }

    public function getGroupStudentUsers($groupId)
    {
        return User::whereHas('student', function($query) use ($groupId) {
            $query->where('group_id', $groupId);
        })->pluck('id');
    }

    public function getSubGroupStudentUsers($subGroupId)
    {
        return User::whereHas('student', function($query) use ($subGroupId) {
            $query->where('sub_group_id', $subGroupId);
        })->pluck('id');
    }

    public function getStudentUser($studentId)
    {
        return Student::findOrFail($studentId)->user()->value('id');
    }

    public function getInstructorUser($instructorId)
    {
        return Instructor::findOrFail($instructorId)->user()->value('id');
    }


    public function getNotificationsByReceiverId($receiverId)
    {
        return Notification::with('sender:id,first_name,last_name, ')->whereHas('receivers', function ($query) use ($receiverId) {
            $query->where('receiver_id', $receiverId);
        })->get();
    }
}
