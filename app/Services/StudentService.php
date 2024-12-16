<?php

namespace App\Services;

use App\Contracts\GenericRepositoryInterface;
use App\Contracts\StudentRepositoryInterface;
use App\Interfaces\Services\StudentServiceInterface;
use App\Models\Student;
use App\Shared\Constants\StatusResponse;
use App\Shared\Handler\Result;
use Illuminate\Support\Facades\Validator;

class StudentService implements StudentServiceInterface
{
    private $studentRepository;
    private $genericRepository;

    public function __construct(
        StudentRepositoryInterface $studentRepository
    ) {
        $this->studentRepository = $studentRepository;
        $this->genericRepository = new GenericRepository(new Student());
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

        return Result::success($result, 'Student found Successfully by ID', StatusResponse::HTTP_OK);
    }

    public function createStudent(array $data)
    {
        $validator = Validator::make($data, [
            'name' => 'required|string',
            'email' => 'required|email|unique:students,email',
            'department_id' => 'required|exists:departments,id',
        ]);

        if ($validator->fails()) {
            return Result::error('Validation failed', 422, $validator->errors());
        }

        $result = $this->genericRepository->create($data);
        return Result::success($result, 'Student Created Successfully', StatusResponse::HTTP_CREATED);
    }

    public function updateStudent($id, array $data)
    {
        $validator = Validator::make($data, [
            'name' => 'required|string',
            'email' => 'required|email|unique:students,email,' . $id,
            'department_id' => 'required|exists:departments,id',
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
        $result = $this->studentRepository->getStudentsByDepartment($departmentId);

        return Result::success($result, 'Students found Successfully by Department', StatusResponse::HTTP_OK);
    }
}
