<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\UsersImport;
use App\Shared\Handler\Result;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Validators\ValidationException;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{
    //
    public function uploadStudents(Request $request)
    {
        try {
            if (!$request->hasFile('file')) {
                return Result::error('No file provided', 400);
            }
    
            $file = $request->file('file');
            if ($file->getClientOriginalExtension() !== 'xlsx') {
                return Result::error('Invalid file type. Only .xlsx files are allowed', 400);
            }
    
            // Import the file
            Excel::import(new UsersImport, $file);

            return Result::success($file, 'File imported successfully', 200);
        } catch (ValidationException $e) {
            return Result::error([
                'error' => 'Validation error in Excel file.',
                'messages' => $e->failures(),
            ], 422);
        } catch (\Exception $e) {
            // Log the error
            Log::error('File upload error: ' . $e->getMessage());
            return Result::error(['An error occurred while importing the file.', 'details' => $e->getMessage()], 500);
        }
    }
    
}
