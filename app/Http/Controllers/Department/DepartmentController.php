<?php

namespace App\Http\Controllers\Department;

use App\Http\Controllers\Controller;
use App\Models\Department;
use Illuminate\Http\Request;
use App\Imports\DepartmentImport;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;

class DepartmentController extends Controller
{
    public function index()
    {
        // return Department::all();

        return response()->json(
            [
                'messgae' => 'fetch all departs successfully'
            ]
        );
    }
    public function createDepartment(Request $request)
    {
        // $data = $request->validate([
        //     'name' => 'required|string|min:3|max:255',
        //     'short_name' => 'required','max:5',
        //     'description' => 'required|string|min:3|max:255',
        // ]);
        // $department = Department::create($data);
        // return response()->json([
        //     'message'=> 'added successfully',
        //     'status'=>201
        // ]); // Return the created department
        try {
            if (!$request->hasFile('file')) {
                return response()->json(['error' => 'No file provided.'], 400);
            }

            $file = $request->file('file');
            if ($file->getClientOriginalExtension() !== 'xlsx') {
                return response()->json(['error' => 'Invalid file type. Only .xlsx files are allowed.'], 400);
            }

            // Import the file
            Excel::import(new DepartmentImport, $file);

            return response()->json(['success' => 'File imported successfully.']);
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            return response()->json([
                'error' => 'Validation error in Excel file.',
                'messages' => $e->failures(),
            ], 422);
        } catch (\Exception $e) {
            // Log the error
            Log::error('File upload error: ' . $e->getMessage());

            return response()->json(['error' => 'An error occurred while importing the file.', 'details' => $e->getMessage()], 500);
        }
    }
}
