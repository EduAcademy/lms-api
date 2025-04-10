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
        $result = $this->instructorService->getAllInstructors();

        return $result;
    }

    public function findByUserId($userId)
    {
        return $this->instructorService->findByUserId($userId);
    }

    public function show($id)
    {
        $result = $this->instructorService->getInstructorById($id);

        return $result;
    }


    public function store(InstructorRequest $request)
    {

        $data = $request->validated();
        $result = $this->instructorService->createInstructor($data);

        return $result;
    }

    public function update(Request $request, $id)
    {

        $result = $this->instructorService->updateInstructor($id, $request->all());

        return $result;
    }

    public function delete($id)
    {
        $result = $this->instructorService->deleteInstructor($id);

        return $result;
    }
}
