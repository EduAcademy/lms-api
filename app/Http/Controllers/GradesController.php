<?php

namespace App\Http\Controllers;

use App\Http\Requests\GradeRequest;
use App\Interfaces\Services\GradeServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class GradesController extends Controller
{
    //
    protected $gradeServiceInterface;
    public function __construct(GradeServiceInterface $gradeServiceInterface)
    {
        $this->gradeServiceInterface = $gradeServiceInterface;
    }

    public function Index()
    {
        $result = $this->gradeServiceInterface->getAll();
        return $result;
    }

    public function getByInstructorId($instructorId)
    {
        $result = $this->gradeServiceInterface->getByInstructorId($instructorId);
        return $result;
    }

    public function getByStudentAndCourse($studentId, $courseId)
    {
        $result = $this->gradeServiceInterface->getByStudentAndCourse($studentId, $courseId);
        return $result;
    }

    public function store(GradeRequest $request)
    {
        Log::info($request->all());
        $data = $request->validated();
        $result = $this->gradeServiceInterface->create($data);
        return $result;
    }
}
