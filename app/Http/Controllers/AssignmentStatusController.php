<?php

namespace App\Http\Controllers;

use App\Models\AssignmentStatus;
use App\Shared\Constants\StatusResponse;
use App\Shared\Handler\Result;
use Illuminate\Http\Request;

class AssignmentStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $result = AssignmentStatus::all();
        return Result::success($result, 'Get All AssignmentStatus', StatusResponse::HTTP_OK);
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
    }

    /**
     * Display the specified resource.
     */
    public function show(AssignmentStatus $assignmentStatus)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AssignmentStatus $assignmentStatus)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AssignmentStatus $assignmentStatus)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AssignmentStatus $assignmentStatus)
    {
        //
    }
}
