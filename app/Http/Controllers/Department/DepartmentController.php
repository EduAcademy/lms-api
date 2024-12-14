<?php

namespace App\Http\Controllers\Department;

use App\Contracts\GenericRepositoryInterface;
use App\Http\Controllers\Controller;
use App\Models\Department;
use Illuminate\Http\Request;
use App\Imports\DepartmentImport;
use App\Models\UploadedFiles;
use App\Repositories\GenericRepository;
use App\Shared\Constants\StatusResponse;
use App\Shared\Handler\Result;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;

class DepartmentController extends Controller
{

    protected $repo;

    public function __construct()
    {
        $this->repo = new GenericRepository(new Department);
    }

    public function index()
    {
        // return Department::all();

        $result = $this->repo->getAll();

        // return response()->json(
        //     [
        //         'messgae' => 'fetch all departs successfully'
        //     ]
        // );

        return Result::success($result, 'Get all Departments Successfully', StatusResponse::HTTP_OK);
    }

    public function createDepartment(Request $request)
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
            'file_name' => $fileName,
            'file_hash' => $fileHash,
            'file_size' => $fileSize,
            'last_modified' => $lastModified,
        ]);

        // Import departments
        try {
            Excel::import(new DepartmentImport, $file);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error processing file: ' . $e->getMessage()], 500);
        }

        return response()->json(['message' => 'File uploaded and processed successfully.']);
    }
}
