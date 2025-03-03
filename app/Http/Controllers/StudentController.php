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
        return $this->studentService->getAllStudents();
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
