<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Interfaces\Services\AssignmentStudentServiceInterface;

class AssignmentStudentController extends Controller
{
    protected $service;

    public function __construct(AssignmentStudentServiceInterface $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $result = $this->service->getAllAssignmentStudents();
        return response()->json($result);
    }

    public function store(Request $request)
    {
        $result = $this->service->createAssignmentStudent($request->all());
        return response()->json($result);
    }

    public function show($id)
    {
        $result = $this->service->getAssignmentStudentById($id);
        return response()->json($result);
    }

    public function update($id, Request $request)
    {
        $result = $this->service->updateAssignmentStudent($id, $request->all());
        return response()->json($result);
    }

    public function destroy($id)
    {
        $result = $this->service->deleteAssignmentStudent($id);
        return response()->json($result);
    }

    public function getByStudentId($studentId)
    {
        $result = $this->service->getByStudentId($studentId);
        return response()->json($result);
    }
}
