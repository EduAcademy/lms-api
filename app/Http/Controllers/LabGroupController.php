<?php

namespace App\Http\Controllers;

use App\Http\Requests\LabGroupRequest;
use App\Interfaces\Services\SubGroupServiceInterface;
use Illuminate\Http\Request;

class LabGroupController extends Controller
{
    //

    protected $sub_groups_service;
    public function __construct(SubGroupServiceInterface $SubGroupService)
    {
        $this->sub_groups_service = $SubGroupService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $result = $this->sub_groups_service->getAllLabGroup();
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
    public function store(LabGroupRequest $request)
    {
        //
        $data = $request->validated();
        $result = $this->sub_groups_service->createLabGroup($data);
        return $result;
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
        $result = $this->sub_groups_service->getLabById($id);
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
        $result = $this->sub_groups_service->updateLabGroup($id, $request->all());
        return $result;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete($id)
    {
        //
        $result = $this->sub_groups_service->deleteLabGroup($id);
        return $result;
    }
}
