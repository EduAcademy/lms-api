<?php

namespace App\Services;

use App\Contracts\AssignmentStudentRepositoryInterface;
use App\Interfaces\Services\AssignmentStudentServiceInterface;
use App\Shared\Handler\Result;
use App\Shared\Constants\StatusResponse;
use Illuminate\Support\Facades\Validator;

class AssignmentStudentService implements AssignmentStudentServiceInterface
{
    protected $repository;

    public function __construct(AssignmentStudentRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function getAllAssignmentStudents()
    {
        $data = $this->repository->getAll();
        return Result::success($data, 'Assignment Students retrieved successfully', StatusResponse::HTTP_OK);
    }

    public function getAssignmentStudentById($id)
    {
        $data = $this->repository->getById($id);
        if (!$data) {
            return Result::error("Assignment Student not found with id {$id}", StatusResponse::HTTP_NOT_FOUND);
        }
        return Result::success($data, 'Assignment Student retrieved successfully', StatusResponse::HTTP_OK);
    }

    public function createAssignmentStudent(array $data)
    {
        // Validate input – now expecting student_id from the request
        $validator = Validator::make($data, [
            'assignment_id' => 'required|exists:assignments,id',
            'student_id'    => 'required|exists:students,id',
        ]);

        if ($validator->fails()) {
            return Result::error('Validation failed', StatusResponse::HTTP_UNPROCESSABLE_ENTITY, $validator->errors());
        }

        // Retrieve the student details using the provided student_id
        $student = \App\Models\Student::find($data['student_id']);
        if (!$student) {
            return Result::error('Student not found', StatusResponse::HTTP_NOT_FOUND);
        }
        
        $name = $student->name ?? 'student';
        $specialization = $student->specialization ?? 'general';
        $group = isset($student->group) ? $student->group->name : 'default';

        // Generate the submission link using the student's details
        $data['submission_link'] = url("assignments/{$data['assignment_id']}/submission/{$name}-{$specialization}-{$group}");

        $assignmentStudent = $this->repository->create($data);
        if (!$assignmentStudent) {
            return Result::error('Failed to create Assignment Student', StatusResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
        return Result::success($assignmentStudent, 'Assignment Student created successfully', StatusResponse::HTTP_CREATED);
    }

    public function updateAssignmentStudent($id, array $data)
    {
        $assignmentStudent = $this->repository->update($id, $data);
        if (!$assignmentStudent) {
            return Result::error('Failed to update Assignment Student', StatusResponse::HTTP_BAD_REQUEST);
        }
        return Result::success($assignmentStudent, 'Assignment Student updated successfully', StatusResponse::HTTP_OK);
    }

    public function deleteAssignmentStudent($id)
    {
        $deleted = $this->repository->delete($id);
        if (!$deleted) {
            return Result::error('Failed to delete Assignment Student', StatusResponse::HTTP_BAD_REQUEST);
        }
        return Result::success($deleted, 'Assignment Student deleted successfully', StatusResponse::HTTP_OK);
    }

    public function getByStudentId($studentId)
    {
        $data = $this->repository->getByStudentId($studentId);
        if (!$data) {
            return Result::error("No Assignment Students found for student id {$studentId}", StatusResponse::HTTP_NOT_FOUND);
        }
        return Result::success($data, 'Assignment Students retrieved successfully', StatusResponse::HTTP_OK);
    }
}
