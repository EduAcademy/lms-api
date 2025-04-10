<?php

namespace App\Http\Controllers;

use App\Interfaces\Services\NotificationServiceInterface;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    //
    protected $notificationService;

    public function __construct(NotificationServiceInterface $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    public function notifyAllStudents(Request $request)
    {
        $validated = $request->validate(['message' => 'required|string|max:500']);

        $this->notificationService->notifyAllStudents(
            auth()->id(),
            $validated['message']
        );

        return response()->json(['message' => 'Notifications sent to all students']);
    }

    public function notifyDepartment(Request $request)
    {
        $validated = $request->validate([
            'department_id' => 'required|exists:departments,id',
            'message' => 'required|string|max:500'
        ]);

        $this->notificationService->sendToDepartment(
            auth()->id(),
            $validated['department_id'],
            $validated['message']
        );

        return response()->json(['message' => 'Notifications sent successfully']);
    }
    public function notifyGroup(Request $request)
    {
        $validated = $request->validate([
            'group_id' => 'required|exists:groups,id',
            'message' => 'required|string|max:500',
        ]);

        $this->notificationService->sendToGroup(
            auth()->id(),
            $validated['group_id'],
            $validated['message']
        );

        return response()->json(['message' => 'Notifications sent successfully']);
    }

    public function notifyStudent(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:users,id',
            'message' => 'required|string|max:500',
        ]);

        $this->notificationService->sendToStudent(
            auth()->id(),
            $validated['student_id'],
            $validated['message']
        );

        return response()->json(['message' => 'Notifications sent to this student Id : ' . $validated['student_id']]);
    }

    public function notifyInstructor(Request $request)
    {
        $validated = $request->validate([
            'instructor_id' => 'required|exists:instructors,id',
            'message' => 'required|string|max:500',
        ]);

        $this->notificationService->sendToInstructor(
            auth()->id(),
            $validated['instructor_id'],
            $validated['message']
        );

        return response()->json(['message' => 'Notifications sent to this instructor Id : ' . $validated['instructor_id']]);
    }

    public function getNotificationsByReceiverId($receiverId)
    {
        $notifications = $this->notificationService->getNotificationsByReceiverId($receiverId);

        return response()->json($notifications);
    }

    public function deleteNotificationReceiver($id)
    {
        $deleted = $this->notificationService->deleteNotificationReceiverById($id);

        if ($deleted) {
            return response()->json(['message' => 'NotificationReceiver deleted successfully']);
        }

        return response()->json(['message' => 'NotificationReceiver not found'], 404);
    }

}
