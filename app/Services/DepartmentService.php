<?php

namespace App\Interfaces\Services;

use App\Contracts\DepartmentRepositoryInterface;
use App\Models\Department;
use App\Shared\Constants\StatusResponse;
use App\Shared\Handler\Result;

class DepartmentService implements DepartmentServiceInterface{
    
    protected $departmentRepository;

    public function __construct(DepartmentRepositoryInterface $departmentRepository)
    {
        $this->$departmentRepository = $departmentRepository;
    }


    public function getDepartmentById($id)
    {
        $result = $this->departmentRepository->getDepartmentById($id);

        return Result::success($result, 'Department is found Successfully by Id', StatusResponse::HTTP_OK);
    }


    public function getDepartmentByShortName($shortName)
    {
        $result = $this->departmentRepository->getDepartmentByShortName($shortName);

        return Result::success($result, 'Department is found Successfully by shortName', StatusResponse::HTTP_OK);
    }

    public function createDepartment(array $data)
    {

    }

    public function updateDepartment(Department $department, array $data)
    {

    }
}