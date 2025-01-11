<?php

namespace App\Http\Controllers;

use App\Interfaces\Services\StudyPlanCourseServiceInterface;
use App\Http\Requests\StudyPlanCourseRequest;
use Database\Seeders\StudyPlanSeeder;
use Illuminate\Http\Request;

class StudyPlanCourseController extends Controller
{
    //
    protected $spCourseService;
    public function __construct(StudyPlanCourseServiceInterface $spCourseService)
    {
        $this->spCourseService = $spCourseService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $result = $this->spCourseService->getAllStudyPlanCourses();

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
    public function store(StudyPlanCourseRequest $request)
    {
        //
        $data = $request->validated();
        $result = $this->spCourseService->createStudyPlanCourse($data);

        return $result;
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
        $result = $this->spCourseService->getStudyPlanCourseById($id);

        return $result;
    }


    /**
     * Update the specified resource in storage.
     */
    public function update($id, Request $request)
    {
        //
        $result = $this->spCourseService->updateStudyPlanCourse($id, $request->all());

        return $result;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete($id)
    {
        //
        $result = $this->spCourseService->deleteStudyPlanCourse($id);

        return $result;
    }
}
