<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use App\Http\Requests\InstructorRequest;
use App\Services\InstructorService;
use Illuminate\Http\Request;

class InstructorController extends Controller
{
    protected $instructorService;


    public function __construct(InstructorService $instructorService)
    {
        $this->instructorService = $instructorService;
    }

    public function index()
    {
        $instructors = $this->instructorService->getAll();
        return response()->json($instructors);
    }


    public function show($id)
    {
        $instructor = $this->instructorService->findById($id);

        if ($instructor) {
            return response()->json($instructor);
        }

        return response()->json(['message' => 'instructor not found'], 404);
    }


    public function store(InstructorRequest $request)
    {

        $data = $request->validated();
        $instructor = $this->instructorService->createInstructor($data);

        return response()->json($instructor, 201);
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

        $instructor = $this->instructorService->updateInstructor($id, $validated);

        if ($instructor) {
            return response()->json($instructor);
        }

        return response()->json(['message' => 'instructor not found'], 404);
    }

    public function destroy($id)
    {
        $deleted = $this->instructorService->deleteInstructor($id);

        if ($deleted) {
            return response()->json(['message' => 'instructor deleted successfully']);
        }

        return response()->json(['message' => 'instructor not found'], 404);
    }
}
