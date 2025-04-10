<?php

namespace App\Http\Controllers;

use App\Http\Requests\StudentRequest;
use Illuminate\Http\Request;
use App\Imports\StudentImport;
use App\Interfaces\Services\StudentServiceInterface;
use App\Models\UploadedFiles;
use App\Models\Student;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;

class StudentController extends Controller
{
    protected $studentService;

    public function __construct(StudentServiceInterface $studentService)
    {
        $this->studentService = $studentService;
    }

    public function index()
    {
        return $this->studentService->getAllStudents();
    }

    public function uploadStudent(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls',
        ]);

        try {
            $result = $this->studentService->uploadAndImportStudents($request->file('file'));
            return response()->json($result->getData(), $result->getStatusCode());
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error processing file: ' . $e->getMessage()], 500);
        }
    }

    public function getStudentsByGroupId($groupId)
    {
        return $this->studentService->getStudentsByGroup($groupId);
    }

    public function getStudentsBySubGroupId($subgroupId)
    {
        return $this->studentService->getStudentsBySubGroupId($subgroupId);
    }

    public function findByUserId($userId)
    {
        return $this->studentService->findByUserId($userId);
    }

    public function show($id)
    {
        // Get the specific student from the service (eager loading is handled in the service)
        return $this->studentService->getStudentById($id);
    }

    public function store(StudentRequest $request)
    {
        $data = $request->validated();
        return $this->studentService->createStudent($data);
    }

    public function update($id, Request $request)
    {
        return $this->studentService->updateStudent($id, $request->all());
    }
}
