<?php

namespace App\Http\Controllers;

use App\Interfaces\Services\LabGroupServiceInterface;
use Illuminate\Http\Request;

class LabGroupController extends Controller
{
    //

    protected $lab_groupService;
    public function __construct(LabGroupServiceInterface $labGroupService)
    {
        $this->lab_groupService = $labGroupService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $result = $this->lab_groupService->getAllLabGroup();
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
        $result = $this->lab_groupService->createLabGroup($request->all());
        return $result;
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
        $result = $this->lab_groupService->getLabById($id);
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
        $result = $this->lab_groupService->updateLabGroup($id, $request->all());
        return $result;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete($id)
    {
        //
        $result = $this->lab_groupService->deleteLabGroup($id);
        return $result;
    }
}
