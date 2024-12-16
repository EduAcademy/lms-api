<?php

namespace App\Http\Controllers;

use App\Interfaces\Services\StudentServiceInterface;
use Illuminate\Http\Request;

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

    public function show($id)
    {
        return $this->studentService->getStudentById($id);
    }

    public function store(Request $request)
    {
        return $this->studentService->createStudent($request->all());
    }

    public function update($id, Request $request)
    {
        return $this->studentService->updateStudent($id, $request->all());
    }

    public function getStudentsByDepartment($departmentId)
    {
        return $this->studentService->getStudentsByDepartment($departmentId);
    }
}
