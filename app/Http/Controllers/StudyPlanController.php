<?php

namespace App\Http\Controllers;

use App\Http\Requests\StudyPlanRequest;
use App\Interfaces\Services\StudyPlanServiceInterface;
use App\Models\StudyPlan;
use Illuminate\Http\Request;

class StudyPlanController extends Controller
{

    protected $study_PlanService;
    public function __construct(StudyPlanServiceInterface $studyPlanService)
    {
        $this->study_PlanService = $studyPlanService;
    }


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $result = $this->study_PlanService->getAllStudyPlans();

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
    public function store(StudyPlanRequest $request)
    {
        //
        $data = $request->validated();
        $result = $this->study_PlanService->createStudyPlan($data);

        return $result;
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
        $result = $this->study_PlanService->getStudyPlanById($id);

        return $result;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(StudyPlan $studyPlan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($id, Request $request)
    {
        //
        $result = $this->study_PlanService->updateStudyPlan($id, $request->all());
        return $result;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
        $result = $this->study_PlanService->deleteStudyPlan($id);
        return $result;
    }
}
