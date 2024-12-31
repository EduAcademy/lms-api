<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use App\Http\Requests\InstructorRequest;
use App\Services\InstructorService;
use Illuminate\Http\Request;

class InstructorController extends Controller
{
    protected $teacherService;


    public function __construct(InstructorService $teacherService)
    {
        $this->teacherService = $teacherService;
    }

    public function index()
    {
        $teachers = $this->teacherService->getAll();
        return response()->json($teachers);
    }


    public function show($id)
    {
        $teacher = $this->teacherService->findById($id);

        if ($teacher) {
            return response()->json($teacher);
        }

        return response()->json(['message' => 'Teacher not found'], 404);
    }


    public function store(InstructorRequest $request)
    {

        $data = $request->validated();
        $teacher = $this->teacherService->createInstructor($data);

        return response()->json($teacher, 201);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'uuid' => 'required|uuid',
            'professional_title' => 'required|string|max:255',
            'about_me' => 'nullable|string',
            'social_links' => 'nullable|url',
            'user_id' => 'required|integer|exists:users,id',
        ]);

        $teacher = $this->teacherService->updateInstructor($id, $validated);

        if ($teacher) {
            return response()->json($teacher);
        }

        return response()->json(['message' => 'Teacher not found'], 404);
    }

    public function destroy($id)
    {
        $deleted = $this->teacherService->deleteInstructor($id);

        if ($deleted) {
            return response()->json(['message' => 'Teacher deleted successfully']);
        }

        return response()->json(['message' => 'Teacher not found'], 404);
    }
}
