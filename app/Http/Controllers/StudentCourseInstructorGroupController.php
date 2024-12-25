<?php

namespace App\Http\Controllers;

use App\Interfaces\Services\StuCouInstrGroupServiceInterface;
use Illuminate\Http\Request;

class StudentCourseInstructorGroupController extends Controller
{
    //

    protected $stu_cou_ins_groService;
    public function __construct(StuCouInstrGroupServiceInterface $stuCouInstrGroupService)
    {
        $this->stu_cou_ins_groService = $stuCouInstrGroupService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $result = $this->stu_cou_ins_groService->getAllStuCouInstrGroups();
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
    public function store(Request $request)
    {
        //
        $result = $this->stu_cou_ins_groService->createStuCouInstrGroup($request->all());
        return $result;
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
        $result = $this->stu_cou_ins_groService->getStuCouInstrGroupById($id);
        return $result;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($id, Request $request)
    {
        //
        $result = $this->stu_cou_ins_groService->updateStuCouInstrGroup($id, $request->all());
        return $result;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete($id)
    {
        //
        $result = $this->stu_cou_ins_groService->deleteStuCouInstrGroup($id);
        return $result;
    }
}
