<?php

namespace App\Http\Controllers;

use App\Contracts\GenericRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Validators\ValidationException;
use App\Imports\UsersImport;

class StudentController extends Controller
{
    private $repository;

    /**
     * Inject the GenericRepositoryInterface.
     */
    public function __construct(GenericRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Display a listing of students.
     */
    public function index()
    {
        $students = $this->repository->getAll(); // Fetch all students using the repository
        return response()->json(['data' => $students], 200);
    }

    /**
     * Store a new student.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'department_id' => 'required|exists:departments,id',
            'study_plan_id' => 'required|exists:study_plans,id',
            'user_id' => 'required|exists:users,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $student = $this->repository->create($request->only(['department_id', 'study_plan_id', 'user_id']));

        return response()->json(['message' => 'Student created successfully.', 'data' => $student], 201);
    }

    /**
     * Display the specified student.
     */
    public function show($id)
    {
        $student = $this->repository->findById($id);

        if (!$student) {
            return response()->json(['error' => 'Student not found.'], 404);
        }

        return response()->json(['data' => $student], 200);
    }

    /**
     * Update the specified student.
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'department_id' => 'sometimes|required|exists:departments,id',
            'study_plan_id' => 'sometimes|required|exists:study_plans,id',
            'user_id' => 'sometimes|required|exists:users,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $student = $this->repository->update($id, $request->only(['department_id', 'study_plan_id', 'user_id']));

        if (!$student) {
            return response()->json(['error' => 'Student not found.'], 404);
        }

        return response()->json(['message' => 'Student updated successfully.', 'data' => $student], 200);
    }

    /**
     * Remove the specified student.
     */
    public function destroy($id)
    {
        $deleted = $this->repository->delete($id);

        if (!$deleted) {
            return response()->json(['error' => 'Student not found.'], 404);
        }

        return response()->json(['message' => 'Student deleted successfully.'], 200);
    }

    /**
     * Upload students from an Excel file.
     */
    public function uploadStudents(Request $request)
    {
        try {
            if (!$request->hasFile('file')) {
                return response()->json(['error' => 'No file provided.'], 400);
            }

            $file = $request->file('file');
            if ($file->getClientOriginalExtension() !== 'xlsx') {
                return response()->json(['error' => 'Invalid file type. Only .xlsx files are allowed.'], 400);
            }

            // Import the file
            Excel::import(new UsersImport, $file);

            return response()->json(['message' => 'File imported successfully.'], 200);
        } catch (ValidationException $e) {
            return response()->json([
                'error' => 'Validation error in Excel file.',
                'messages' => $e->failures(),
            ], 422);
        } catch (\Exception $e) {
            Log::error('File upload error: ' . $e->getMessage());
            return response()->json(['error' => 'An error occurred while importing the file.'], 500);
        }
    }
}
