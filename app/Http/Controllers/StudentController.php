<?php

namespace App\Http\Controllers;

use App\Http\Requests\StudentRequest;
use Illuminate\Http\Request;
use App\Imports\StudentImport;
use App\Interfaces\Services\StudentServiceInterface;
use App\Models\UploadedFiles;
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
        // Get all students from the service
        $students = $this->studentService->getAllStudents();
        // Eager load the 'user' relationship so each student includes its linked user data
        $students->load('user');

        return response()->json([
            "status"  => 200,
            "message" => "Get all Students Successfully",
            "data"    => $students,
        ]);
    }

    public function uploadStudent(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls',
        ]);

        $file = $request->file('file');
        $filePath = $file->getRealPath();

        // Generate a hash for the file
        $fileHash = hash_file('sha256', $filePath);
        $fileSize = $file->getSize();
        $lastModified = Carbon::createFromTimestamp($file->getMTime())->toDateTimeString();
        $fileName = $file->getClientOriginalName();

        // Check if the file has been uploaded before
        $existingFile = UploadedFiles::where('file_hash', $fileHash)
            ->orWhere(function ($query) use ($fileName, $fileSize, $lastModified) {
                $query->where('file_name', $fileName)
                      ->where('file_size', $fileSize)
                      ->where('last_modified', $lastModified);
            })
            ->first();

        if ($existingFile) {
            return response()->json(['error' => 'This file has already been uploaded and processed.'], 400);
        }

        // Store file metadata
        UploadedFiles::create([
            'file_name'     => $fileName,
            'file_hash'     => $fileHash,
            'file_size'     => $fileSize,
            'last_modified' => $lastModified,
        ]);

        // Import students
        try {
            Excel::import(new StudentImport, $file);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error processing file: ' . $e->getMessage()], 500);
        }

        return response()->json(['message' => 'File uploaded and processed successfully.']);
    }

    public function show($id)
    {
        // Get the specific student from the service
        $student = $this->studentService->getStudentById($id);
        // Eager load the 'user' relationship
        $student->load('user');

        return response()->json([
            "status"  => 200,
            "message" => "Student retrieved successfully",
            "data"    => $student,
        ]);
    }

    public function store(StudentRequest $request)
    {
        $data = $request->validated();
        $result = $this->studentService->createStudent($data);
        return $result;
    }

    public function update($id, Request $request)
    {
        $result = $this->studentService->updateStudent($id, $request->all());
        return $result;
    }
}
