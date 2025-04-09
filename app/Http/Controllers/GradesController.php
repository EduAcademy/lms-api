<?php

namespace App\Http\Controllers;

use App\Http\Requests\GradeRequest;
use App\Interfaces\Services\GradeServiceInterface;
use Illuminate\Http\Request;

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

    }

    public function getByInstructorId($instructorId)
    {

    }

    public function getByStudentAndCourse($studentId, $courseId)
    {

    }

    public function store(GradeRequest $request)
    {
        $data = $request->validated();
    }
}
