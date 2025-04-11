<?php

namespace App\Http\Controllers;

use App\Http\Requests\AbsenceRequest;
use App\Interfaces\Services\AbsenceServiceInterface;
use App\Services\AbsenceService;
use Illuminate\Http\Request;

class AbsenceController extends Controller
{

    protected $absenceServiceInterface;
    public function __construct(AbsenceServiceInterface $absenceServiceInterface)
    {
        $this->absenceServiceInterface = $absenceServiceInterface;
    }

    public function index()
    {
        return $this->absenceServiceInterface->getAllAbsence();
    }

    public function store(AbsenceRequest $request)
    {
        $data = $request->validated();
        $result = $this->absenceServiceInterface->createAbsence($data);
        return $result;
    }

    public function getAbsenceCountByStudentAndCourse($studentId, $courseId)
    {
        $result = $this->absenceServiceInterface->getAbsenceCountByStudentAndCourse($studentId, $courseId);
        return $result;
    }
}
