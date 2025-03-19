<?php

namespace App\Services;

use App\Contracts\StudentRepositoryInterface;
use App\DTOs\StudentDTO;
use App\Http\Requests\StudentRequest;
use App\Interfaces\Services\StudentServiceInterface;
use App\Mappings\StudentMapping;
use App\Models\Student;
use App\Repositories\GenericRepository;
use App\Shared\Constants\MessageResponse;
use App\Shared\Constants\StatusResponse;
use App\Shared\Handler\Result;
use Exception;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class StudentService implements StudentServiceInterface
{
    private $studentRepository;
    private $genericRepository;

    public function __construct(
        StudentRepositoryInterface $studentRepository
    ) {
        $this->studentRepository = $studentRepository;
        $this->genericRepository = new GenericRepository(new Student);
    }

    public function getAllStudents()
    {
        try {
            // Eager load related models using the relationship names from Student.php
            $result = Student::with(['user', 'department', 'study_plan', 'group', 'sub_group'])
                ->whereHas('user', function ($query) {
                    $query->where('role_id', 3);
                })
                ->get();

            return Result::success($result, MessageResponse::RETRIEVED_SUCCESSFULLY, StatusResponse::HTTP_OK);
        } catch (Exception $e) {
            Log::error('Error in StudentService::getAllStudents: ' . $e->getMessage());
            return Result::error('An error occurred while fetching students', StatusResponse::HTTP_INTERNAL_SERVER_ERROR, $e->getMessage());
        }
    }

    public function getStudentById($id)
    {
        $student = $this->studentRepository->findById($id);

        if (!$student) {
            return Result::error(MessageResponse::RESOURCE_NOT_FOUND, StatusResponse::HTTP_NOT_FOUND);
        }

        // Eager load the related models using the defined relationship names.
        $student->load(['user', 'department', 'study_plan', 'group', 'sub_group']);

        $studentData = StudentMapping::toStudent($student);
        $result = StudentDTO::fromArray($studentData);

        return Result::success($result, MessageResponse::RETRIEVED_SUCCESSFULLY, StatusResponse::HTTP_OK);
    }

    public function createStudent(array $data)
    {
        // Validate input using StudentRequest rules.
        $validator = Validator::make($data, (new StudentRequest())->rules());

        if ($validator->fails()) {
            return Result::error('Validation failed', 422, $validator->errors());
        }

        $result = $this->genericRepository->create($data);

        if (!$result) {
            return Result::error('Failed in creating Student', StatusResponse::HTTP_INTERNAL_SERVER_ERROR);
        }

        return Result::success($result, 'Student is Created Successfully', StatusResponse::HTTP_CREATED);
    }

    public function updateStudent($id, array $data)
    {
        // Validate input data.
        $validator = Validator::make($data, [
            'uuid'           => 'required|string|unique:students,uuid,' . $id,
            'department_id'  => 'required|exists:departments,id',
            'study_plan_id'  => 'required|exists:study_plans,id',
            'user_id'        => 'required|exists:users,id',
            'group_id'       => 'required|exists:groups,id',
            'sub_group_id'   => 'required|exists:sub_groups,id',
        ]);

        if ($validator->fails()) {
            return Result::error('Validation failed', 422, $validator->errors());
        }

        $updatedStudent = $this->genericRepository->update($id, $data);

        if (!$updatedStudent) {
            return Result::error('Failed to update student', StatusResponse::HTTP_BAD_REQUEST);
        }

        return Result::success($updatedStudent, 'Student Updated Successfully', StatusResponse::HTTP_OK);
    }

    public function getStudentsByDepartment($departmentId)
    {
        $students = $this->studentRepository->findByDepartmentId($departmentId);

        if ($students->isEmpty()) {
            return Result::error('No students found for the given department', StatusResponse::HTTP_NOT_FOUND);
        }

        // Eager load related models.
        $students->load(['user', 'department', 'study_plan', 'group', 'sub_group']);

        return Result::success($students, 'Students found Successfully by department', StatusResponse::HTTP_OK);
    }

    public function count(): int
    {
        return $this->studentRepository->count();
    }
}
