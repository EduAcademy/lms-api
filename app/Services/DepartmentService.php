<?php

namespace App\Services;

use App\Contracts\DepartmentRepositoryInterface;
use App\Contracts\GenericRepositoryInterface;
use App\Http\Requests\DepartmentRequest;
use App\Interfaces\Services\DepartmentServiceInterface;
use App\Models\Department;
use App\Repositories\GenericRepository;
use App\Shared\Constants\StatusResponse;
use App\Shared\Handler\Result;
use Illuminate\Support\Facades\Validator;

class DepartmentService implements DepartmentServiceInterface
{
    private $departmentRepository;
    private $genericRepository;

    public function __construct(
        DepartmentRepositoryInterface $departmentRepository,
    ) {
        $this->departmentRepository = $departmentRepository;
        $this->genericRepository = new GenericRepository(new Department);
    }

    public function getAllDepartments()
    {
        $result = $this->genericRepository->getAll();
        return Result::success($result, 'Get all Departments Successfully', StatusResponse::HTTP_OK);
    }

    public function getDepartmentById($id)
    {
        $result = $this->departmentRepository->findById($id);

        if (!$result) {
            return Result::error('Department not found', StatusResponse::HTTP_NOT_FOUND);
        }

        return Result::success($result, 'Department found Successfully by Id', StatusResponse::HTTP_OK);
    }

    public function createDepartment(array $data)
    {
        // Additional Validation Logic
        $existingDepartment = $this->departmentRepository->findByShortName($data['short_name']);
        if ($existingDepartment) {
            return Result::error('Department with the same short name already exists', StatusResponse::HTTP_CONFLICT);
        }

        $validator = Validator::make($data, (new DepartmentRequest())->rules());

        if ($validator->fails()) {
            return Result::error('Validation failed', 422, $validator->errors());
        }

        $result = $this->genericRepository->create($data);

        if (!$result) {
            return Result::error('Failed in creating Department', StatusResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
        return Result::success($result, 'Department Created Successfully', StatusResponse::HTTP_CREATED);
    }

    public function getDepartmentByShortName($shortName)
    {
        $result = $this->departmentRepository->findByShortName($shortName);

        if (!$result) {
            return Result::error('Department not found', StatusResponse::HTTP_NOT_FOUND);
        }

        return Result::success($result, 'Department found Successfully by short name', StatusResponse::HTTP_OK);
    }

    public function updateDepartment($id, array $data)
    {

        $validator = Validator::make($data, [
            'name' => "required|string",
            'short_name' => 'required|string|min:2',
            'description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return Result::error('Validation failed', 422, $validator->errors());
        }

        $updatedDepartment = $this->genericRepository->update($id, $data);

        if (!$updatedDepartment) {
            return Result::error('Failed to update department', StatusResponse::HTTP_BAD_REQUEST);
        }

        return Result::success($updatedDepartment, 'Department Updated Successfully', StatusResponse::HTTP_OK);
    }

    public function deleteDepartment($id)
    {
        $result = $this->genericRepository->delete($id);

        return Result::success($result, 'Department is Deleted Successfully', StatusResponse::HTTP_OK);
    }
}
