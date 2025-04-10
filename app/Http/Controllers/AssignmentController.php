<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use Illuminate\Http\Request;
use App\Services\AssignmentService;
use App\Http\Requests\AssignmentRequest;
use App\Interfaces\Services\AssignmentServiceInterface;
use Illuminate\Support\Facades\Log;

class AssignmentController extends Controller
{
    protected $assignmentServiceInterface;

    public function __construct(AssignmentServiceInterface $assignmentServiceInterface)
    {
        $this->assignmentServiceInterface = $assignmentServiceInterface;
    }

    public function index()
    {
        $result = $this->assignmentServiceInterface->getAllAssignment();
        return $result;
    }

    public function store(Request $request)
    {
        Log::info($request->all());
        $result = $this->assignmentServiceInterface->createAssignment($request->all());
        return response()->json($result);
    }

    public function show($id)
    {
        $result = $this->assignmentServiceInterface->getAssignmentById($id);
        return $result;
    }

    public function update($id, Request $request)
    {
        $result = $this->assignmentServiceInterface->updateAssignment($id, $request->all());
        return response()->json($result);
    }

    public function destroy($id)
    {
        $result = $this->assignmentServiceInterface->deleteAssignment($id);
        return response()->json($result);
    }

    public function getbyInstructorId($instructorId)
    {
        $result = $this->assignmentServiceInterface->getbyInstructorId($instructorId);
        return $result;
    }
    public function getbyGroupId($groupId)
    {
        $result = $this->assignmentServiceInterface->getbyGroupId($groupId);
        return $result;
    }

    public function getbySubGroupId($subGroupId)
    {
        $result = $this->assignmentServiceInterface->getbySubGroupId($subGroupId);
        return $result;
    }
}
