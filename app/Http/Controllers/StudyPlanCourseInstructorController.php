<?php

namespace App\Http\Controllers;

use App\Http\Requests\StudyPlanCourseInstructorRequest;
use App\Interfaces\Services\StudyPlanCourseInstructorServiceInterface;
use Illuminate\Http\Request;

class StudyPlanCourseInstructorController extends Controller
{
    //
    protected $spCInstructorService;
    public function __construct(StudyPlanCourseInstructorServiceInterface $spCInstructorService)
    {
        $this->spCInstructorService = $spCInstructorService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $result = $this->spCInstructorService->getAllSpCInstructors();

        return $result;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StudyPlanCourseInstructorRequest $request)
    {
        //
        $data = $request->validated();
        $result = $this->spCInstructorService->createSpCInstructor($data);

        return $result;
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
        $result = $this->spCInstructorService->getSpCInstructorById($id);
        return $result;
    }

    public function getDepartmentsByInstructorId($instructorId)
    {
        $result = $this->spCInstructorService->getDepartmentsByInstructorId($instructorId);
        return $result;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($id, Request $request)
    {
        //
        $result = $this->spCInstructorService->updateSpCInstructor($id, $request->all());

        return $result;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete($id)
    {
        //
        $result = $this->spCInstructorService->deleteSpCInstructor($id);

        return $result;
    }
}
