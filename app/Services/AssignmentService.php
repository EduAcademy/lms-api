<?php

namespace App\Services;

use App\Models\Assignment;
use App\Http\Requests\AssignmentRequest;
use App\Repositories\GenericRepository;
use App\Shared\Handler\Result;
use App\Shared\Constants\StatusResponse;
use Illuminate\Support\Facades\Validator;
use App\Contracts\AssignmentRepositoryInterface;
use App\Interfaces\Services\AssignmentServiceInterface;
use App\Interfaces\Services\NotificationServiceInterface;
use App\Interfaces\Services\StudyPlanCourseInstructorServiceInterface;
use App\Interfaces\Services\StudyPlanCourseInstructorSubGroupServiceInterface;
use Illuminate\Support\Facades\Log;

class AssignmentService implements AssignmentServiceInterface
{
    protected $assignmentRepository;
    protected $genericRepository;
    protected $spCInstructorService;
    protected $notificationService;
    protected $sPCInstructorSubGroupService;

    public function __construct(
        AssignmentRepositoryInterface $assignmentRepository,
        StudyPlanCourseInstructorServiceInterface $spCInstructorService,
        NotificationServiceInterface $notificationService,
        StudyPlanCourseInstructorSubGroupServiceInterface $sPCInstructorSubGroupService
    ) {
        $this->assignmentRepository = $assignmentRepository;
        $this->genericRepository = new GenericRepository(new Assignment());
        $this->spCInstructorService = $spCInstructorService;
        $this->notificationService = $notificationService;
        $this->sPCInstructorSubGroupService = $sPCInstructorSubGroupService;
    }

    public function getAllAssignment()
    {
        $assignments = $this->assignmentRepository->getAll();
        return Result::success($assignments, 'Get all Assignments successfully', StatusResponse::HTTP_OK);
    }

    public function getAssignmentById($id)
    {
        $assignment = $this->assignmentRepository->getbyId($id);

        if (!$assignment) {
            return Result::error("Assignment not found with Id {$id}", StatusResponse::HTTP_NOT_FOUND);
        }

        return Result::success($assignment, 'Assignment found successfully', StatusResponse::HTTP_OK);
    }

    public function createAssignment(array $data)
    {
        // Validate input
        $validator = Validator::make($data, (new AssignmentRequest())->rules());

        if ($validator->fails()) {
            return Result::error('Validation failed', StatusResponse::HTTP_UNPROCESSABLE_ENTITY, $validator->errors());
        }

        // Create assignment
        $assignment = $this->assignmentRepository->create($data);

        if (!$assignment) {
            return Result::error('Failed to create Assignment', StatusResponse::HTTP_INTERNAL_SERVER_ERROR);
        }

        // Send notification if applicable
        $this->sendAssignmentNotification($data);

        return Result::success($assignment, 'Assignment created successfully', StatusResponse::HTTP_CREATED);
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
            return Result::error('Validation failed', StatusResponse::HTTP_UNPROCESSABLE_ENTITY, $validator->errors());
        }

        $updatedAssignment = $this->genericRepository->update($id, $data);

        if (!$updatedAssignment) {
            return Result::error('Failed to update Assignment', StatusResponse::HTTP_BAD_REQUEST);
        }

        return Result::success($updatedAssignment, 'Assignment updated successfully', StatusResponse::HTTP_OK);
    }

    public function deleteAssignment($id)
    {
        $deleted = $this->genericRepository->delete($id);

        if (!$deleted) {
            return Result::error('Failed to delete Assignment', StatusResponse::HTTP_BAD_REQUEST);
        }

        return Result::success($deleted, 'Assignment deleted successfully', StatusResponse::HTTP_OK);
    }

    public function getbyInstructorId($instructorId)
    {
        $assignments = $this->assignmentRepository->getbyInstructorId($instructorId);

        if (!$assignments) {
            return Result::error("No assignments found for instructor ID {$instructorId}", StatusResponse::HTTP_NOT_FOUND);
        }

        return Result::success($assignments, 'Assignments found successfully', StatusResponse::HTTP_OK);
    }

    public function getbyGroupId($groupId)
    {
        $assignments = $this->assignmentRepository->getbyGroupId($groupId);

        if (!$assignments) {
            return Result::error("No assignments found for group ID {$groupId}", StatusResponse::HTTP_NOT_FOUND);
        }

        return Result::success($assignments, 'Assignments found successfully', StatusResponse::HTTP_OK);
    }

    public function getbySubGroupId($subGroupId)
    {
        $assignments = $this->assignmentRepository->getbySubGroupId($subGroupId);

        if (!$assignments) {
            return Result::error("No assignments found for subgroup ID {$subGroupId}", StatusResponse::HTTP_NOT_FOUND);
        }

        return Result::success($assignments, 'Assignments found successfully', StatusResponse::HTTP_OK);
    }

    /**
     * Handle notification logic after assignment creation.
     */
    protected function sendAssignmentNotification(array $assignment)
    {

        if($assignment['study_plan_course_instructor_sub_group_id'])
        {
            Log::info('The Dtat coming frm the front : ' .$assignment['study_plan_course_instructor_sub_group_id']);
            $response = $this->sPCInstructorSubGroupService->getSpCInstSubGrouById($assignment['study_plan_course_instructor_sub_group_id']);
            $data = $response->getData(true);//

            if ($data['status'] === 200) {
                $instructorData = $data['data'];

                // Optional: update assignment instructor_id in DB if needed
                $assignment['instructor_id'] = $instructorData['instructor_id'];

                $this->notificationService->sendToSubGroup(
                    auth()->id(),
                    $instructorData['sub_group_id'],
                    $assignment['title']
                );
            }
        }
        $response = $this->spCInstructorService->getSpCInstructorById($assignment['study_plan_course_instructor_id']);
        Log::info('Subgroup is null ' . $response);
        $data = $response->getData(true);//

        if ($data['status'] === 200) {
            $instructorData = $data['data'];

            // Optional: update assignment instructor_id in DB if needed
            $assignment['instructor_id'] = $instructorData['instructor_id'];

            $this->notificationService->sendToGroup(
                auth()->id(),
                $instructorData['group_id'],
                $assignment['title']
            );
        }
    }
}
