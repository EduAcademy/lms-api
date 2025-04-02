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
}
