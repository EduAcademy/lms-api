<?php

namespace App\Services;

use App\Models\Assignment;
use App\Shared\Handler\Result;
use App\Repositories\GenericRepository;
use App\Http\Requests\AssignmentRequest;
use App\Shared\Constants\StatusResponse;
use Illuminate\Support\Facades\Validator;
use App\Contracts\AssignmentRepositoryInterface;
use App\Interfaces\Services\AssignmentServiceInterface;

class AssignmentService implements AssignmentServiceInterface
{
    private $assignmentRepository;
    private $genericRepository;

    public function __construct(AssignmentRepositoryInterface $assignmentRepository)
    {
        $this->assignmentRepository = $assignmentRepository;
        $this->genericRepository = new GenericRepository(new Assignment());
    }


    public function getAllAssignment()
    {
        $result = $this->assignmentRepository->getAll();

        return Result::success($result, 'Get all Assignment Successfully', StatusResponse::HTTP_OK);
    }

    public function createAssignment(array $data)
    {
        $validator = Validator::make($data, (new AssignmentRequest())->rules());

        if ($validator->fails()) {
            return Result::error('Validation failed', 422, $validator->errors());
        }
        $result = $this->assignmentRepository->create($data);

        if (!$result) {
            return Result::error('Failed in creating Assignment', StatusResponse::HTTP_INTERNAL_SERVER_ERROR);
        }

        return Result::success($result, 'Assignment is Created Successfully', StatusResponse::HTTP_CREATED);
    }

    public function getAssignmentById($id)
    {
        $result = $this->assignmentRepository->getbyId($id);

        if (!$result) {
            return Result::error("Assignment not found with this Id {$id}", StatusResponse::HTTP_NOT_FOUND);
        }

        return Result::success($result, 'Assignment found Successfully by Id', StatusResponse::HTTP_OK);
    }



    public function updateAssignment($id, array $data)
    {
        $validator = Validator::make($data, [
            'title' => 'required|string|max:255',
            'instructions' => 'nullable|string',
            'due_date' => 'required|date|after_or_equal:today',
            'instructor_id' => 'required|exists:instructors,id',
            'study_plan_course_instructor_id' => 'required|exists:spc_instructors,id',
            'study_plan_course_instructor_sub_group_id' => 'nullable',

        ]);

        if ($validator->fails()) {
            // Include detailed error messages
            return Result::error('Validation failed', 422, $validator->errors());
        }

        $updatedAssignment = $this->genericRepository->update($id, $data);

        if (!$updatedAssignment) {
            return Result::error('Failed to update Assignment', StatusResponse::HTTP_BAD_REQUEST);
        }

        return Result::success($updatedAssignment, 'Assignment Updated Successfully', StatusResponse::HTTP_OK);
    }

    public function deleteAssignment($id)
    {
        $result = $this->genericRepository->delete($id);

        return Result::success($result, 'Assignment is Deleted Successfully', StatusResponse::HTTP_OK);
    }


    public function getbyInstructorId($instructorId)
    {
        $result = $this->assignmentRepository->getbyInstructorId($instructorId);

        if (!$result) {
            return Result::error("Assignment not found with this InstructorId {$instructorId}", StatusResponse::HTTP_NOT_FOUND);
        }

        return Result::success($result, 'Assignment found Successfully by Id', StatusResponse::HTTP_OK);
    }
    public function getbyGroupId($groupId)
    {
        $result = $this->assignmentRepository->getbyGroupId($groupId);

        if (!$result) {
            return Result::error("Assignment not found with this GroupId {$groupId}", StatusResponse::HTTP_NOT_FOUND);
        }

        return Result::success($result, 'Assignment found Successfully by Id', StatusResponse::HTTP_OK);
    }
 

}
