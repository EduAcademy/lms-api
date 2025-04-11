<?php

namespace App\Http\Controllers;

use App\Http\Requests\SubGroupRequest;
use App\Interfaces\Services\SubGroupServiceInterface;
use Illuminate\Http\Request;

class SubGroupController extends Controller
{
    //

    private $sub_groupservice;
    public function __construct(SubGroupserviceInterface $subGroupservice)
    {
        $this->sub_groupservice = $subGroupservice;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $result = $this->sub_groupservice->getAllSubGroups();
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
    public function store(SubGroupRequest $request)
    {
        //
        $data = $request->validated();
        $result = $this->sub_groupservice->createSubGroup($data);
        return $result;
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
        $result = $this->sub_groupservice->getSubGroupById($id);
        return $result;
    }

    public function showByName($name)
    {
        $result = $this->sub_groupservice->getSubGroupByName($name);
        return $result;
    }

    public function showByGroupId($id)
    {
        $result = $this->sub_groupservice->getSubGroupByGroupId($id);
        return $result;
    }

    public function getSubGroupByInstructorId($instructorId)
    {
        $result = $this->sub_groupservice->getSubGroupByInstructorId($instructorId);
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
        $result = $this->sub_groupservice->updateSubGroup($id, $request->all());
        return $result;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
        $result = $this->sub_groupservice->deleteSubGroup($id);
        return $result;
    }
}
