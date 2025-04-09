<?php

namespace App\Http\Controllers;

use App\Http\Requests\StudyPlanCourseInstructorSubGroupRequest;
use App\Interfaces\Services\StudyPlanCourseInstructorSubGroupServiceInterface;
use Illuminate\Http\Request;

class StudyPlanCourseInstructorSubGroupController extends Controller
{
    //

    protected $spCInstrSubGroupService;
    public function __construct(StudyPlanCourseInstructorSubGroupServiceInterface $spCInstrSubGroupService)
    {
        $this->spCInstrSubGroupService = $spCInstrSubGroupService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $result = $this->spCInstrSubGroupService->getAllSpCInstSubGrou();

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
    public function store(StudyPlanCourseInstructorSubGroupRequest $request)
    {
        //
        $data = $request->validated();
        $result = $this->spCInstrSubGroupService->createSpCInstSubGrou($data);

        return $result;
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
        $result = $this->spCInstrSubGroupService->getSpCInstSubGrouById($id);

        return $result;
    }

    public function getCoursesBySubGroupId($subGroupId)
    {
        //
        $result = $this->spCInstrSubGroupService->getCoursesBySubGroupId($subGroupId);

        return $result;
    }


    /**
     * Update the specified resource in storage.
     */
    public function update($id, Request $request)
    {
        //
        $result = $this->spCInstrSubGroupService->updateSpCInstSubGrou($id, $request->all());

        return $result;
    }

    public function getSubGroupsByCourseLevel($courseId, $levelId)
    {
        $result = $this->spCInstrSubGroupService->getSubGroupsByCourseLevel($courseId, $levelId);
        return $result;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete($id)
    {
        //
        $result = $this->spCInstrSubGroupService->deleteSpCInstSubGrou($id);

        return $result;
    }
}
