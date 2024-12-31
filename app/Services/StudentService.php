<?php

namespace App\Services;

use App\Contracts\GenericRepositoryInterface;
use App\Contracts\StudentRepositoryInterface;
use App\Http\Requests\StudentRequest;
use App\Interfaces\Services\StudentServiceInterface;
use App\Models\Student;
use App\Repositories\GenericRepository;
use App\Shared\Constants\StatusResponse;
use App\Shared\Handler\Result;
use Illuminate\Support\Facades\Validator;

class StudentService implements StudentServiceInterface
{
    private $studentRepository;
    private $genericRepository;

    public function __construct(
        StudentRepositoryInterface $studentRepository,
    ) {
        $this->studentRepository = $studentRepository;
        $this->genericRepository = new GenericRepository(new Student);
    }

    public function getAllStudents()
    {
        $result = $this->genericRepository->getAll();
        return Result::success($result, 'Get all Students Successfully', StatusResponse::HTTP_OK);
    }

    public function getStudentById($id)
    {
        $result = $this->studentRepository->findById($id);

        if (!$result) {
            return Result::error('Student not found', StatusResponse::HTTP_NOT_FOUND);
        }

        return Result::success($result, 'Student found Successfully by Id', StatusResponse::HTTP_OK);
    }

    public function createStudent(array $data)
    {
        // Additional Validation Logic
        // $existingStudent = $this->studentRepository->findByUuid($data['uuid']);
        // if ($existingStudent) {
        //     return Result::error('Student with the same UUID already exists', StatusResponse::HTTP_CONFLICT);
        // }

        $validator = Validator::make($data, (new StudentRequest())->rules());

        if ($validator->fails()) {
            return Result::error('Validation failed', 422, $validator->errors());
        }

        $result = $this->genericRepository->create($data);

        if(!$result)
        {
            return Result::error('Failed in creating Student', StatusResponse::HTTP_INTERNAL_SERVER_ERROR);
        }

        return Result::success($result, 'Student is Created Successfully', StatusResponse::HTTP_CREATED);
    }

    public function updateStudent($id, array $data)
    {
        $validator = Validator::make($data, [
            'uuid' => 'required|string|unique:students,uuid,' . $id,
            'department_id' => 'required|exists:departments,id',
            'study_plan_id' => 'required|exists:study_plans,id',
            'user_id' => 'required|exists:users,id',
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

        return Result::success($students, 'Students found Successfully by department', StatusResponse::HTTP_OK);
    }
}
