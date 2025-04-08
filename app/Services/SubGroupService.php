<?php

namespace App\Services;

use App\Contracts\SubGroupRepositoryInterface;
use App\Http\Requests\SubGroupRequest;
use App\Interfaces\Services\SubGroupServiceInterface;
use App\Models\SubGroups;
use App\Repositories\GenericRepository;
use App\Shared\Constants\StatusResponse;
use App\Shared\Handler\Result;
use Illuminate\Support\Facades\Validator;

class SubGroupservice implements SubGroupServiceInterface
{
    /**
     * Create a new class instance.
     */
    private $subGroupRepository;
    private $genericRepository;
    public function __construct(SubGroupRepositoryInterface $subGroupRepository)
    {
        //
        $this->subGroupRepository = $subGroupRepository;
        $this->genericRepository = new GenericRepository(new SubGroups);
    }


    public function getAllSubGroups()
    {
        $result = $this->subGroupRepository->getAll();
        return Result::success($result, 'Get all Sub groups Successfully', StatusResponse::HTTP_OK);
    }

    public function getSubGroupById($id)
    {
        $result = $this->subGroupRepository->getById($id);

        if (!$result) {
            return Result::error("SubGroup not found with this Id {$id}", StatusResponse::HTTP_NOT_FOUND);
        }

        return Result::success($result, 'Sub group is found Successfully by Id', StatusResponse::HTTP_OK);
    }

    public function getSubGroupByName($name)
    {
        $result = $this->subGroupRepository->getByName($name);

        if (!$result) {
            return Result::error("SubGroup not found with this Id {$name}", StatusResponse::HTTP_NOT_FOUND);
        }

        return Result::success($result, 'Sub group is found Successfully by Name', StatusResponse::HTTP_OK);
    }

    public function createSubGroup(array $data)
    {
        $validator = Validator::make($data, (new SubGroupRequest())->rules());

        if ($validator->fails()) {
            return Result::error('Validation failed', 422, $validator->errors());
        }
        $result = $this->subGroupRepository->create($data);

        if (!$result) {
            return Result::error('Failed in creating Sub gourps', StatusResponse::HTTP_INTERNAL_SERVER_ERROR);
        }

        return Result::success($result, 'SubGroup is Created Successfully', StatusResponse::HTTP_CREATED);
    }

    public function getSubGroupByGroupId($groupId)
    {
        $result = $this->subGroupRepository->getByGroupId($groupId);

        if (!$result) {
            return Result::error("SubGroup not found with this Id {$groupId}", StatusResponse::HTTP_NOT_FOUND);
        }

        return Result::success($result, 'SubGroup is found Successfully by groupId', StatusResponse::HTTP_OK);
    }

    public function getSubGroupByInstructorId($instructorId)
    {
        $result = $this->subGroupRepository->getByInstructorId($instructorId);

        if (!$result) {
            return Result::error("SubGroup not found with this Id {$instructorId}", StatusResponse::HTTP_NOT_FOUND);
        }

        return Result::success($result, 'Sub group is found Successfully by InstructorId', StatusResponse::HTTP_OK);
    }



    public function updateSubGroup($id, array $data)
    {
        $validator = Validator::make($data, [
            'name' => 'required|string|unique:sub_groups,name,' . $id,
            'group_id' => 'required|integer|exists:groups,id',
            'instructor_id' => 'required|integer|exists:instructors,id',
        ]);

        if ($validator->fails()) {
            // Include detailed error messages
            return Result::error('Validation failed', 422, $validator->errors());
        }

        $updatedSubgroup = $this->genericRepository->update($id, $data);

        if (!$updatedSubgroup) {
            return Result::error('Failed to update SubGroup', StatusResponse::HTTP_BAD_REQUEST);
        }

        return Result::success($updatedSubgroup, 'SubGroup is updated Successfully', StatusResponse::HTTP_OK);
    }


    public function deleteSubGroup($id)
    {
        $result = $this->genericRepository->delete($id);

        return Result::success($result, 'Sub group is Deleted Successfully', StatusResponse::HTTP_OK);
    }
}
