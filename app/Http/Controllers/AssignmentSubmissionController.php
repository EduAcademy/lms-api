<?php

namespace App\Http\Controllers;

use App\Http\Requests\AssignmentSubmissionRequest;
use App\Http\Requests\UpdateAssignmentSubmissionRequest;
use App\Models\AssignmentSubmission;
use App\Shared\Constants\StatusResponse;
use App\Shared\Handler\Result;
use Illuminate\Http\Request;

class AssignmentSubmissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $result = AssignmentSubmission::all();
        return Result::success($result, 'Get All assignmentsubmissions successfully', StatusResponse::HTTP_OK);
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
    public function store(AssignmentSubmissionRequest $request)
    {
        //
        $data = $request->validated();
        $result = AssignmentSubmission::create($data);
        return Result::success($result, 'A new assignmentsubmission is created successfully', StatusResponse::HTTP_OK);
    }

    /**
     * Display the specified resource.
     */
    public function show(AssignmentSubmission $assignmentSubmission)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AssignmentSubmission $assignmentSubmission)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($id, UpdateAssignmentSubmissionRequest $request)
    {
        $data = $request->validated();

        $submission = AssignmentSubmission::findOrFail($id);
        $submission->update($data);

        return Result::success($submission, 'AssignmentSubmission is updated successfully', StatusResponse::HTTP_OK);
    }

    public function getByStudentAssignment($studentId, $assignmentId)
    {
        $submission = AssignmentSubmission::where('student_id', $studentId)
            ->where('assignment_id', $assignmentId)
            ->first();
        return Result::success($submission, 'Get All assignmentsubmissions by student and assignemt successfully', StatusResponse::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AssignmentSubmission $assignmentSubmission)
    {
        //
    }
}
