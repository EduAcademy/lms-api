<?php

namespace App\Services;

use App\Contracts\SubGroupRepositoryInterface;
use App\Http\Requests\SubGroupRequest;
use App\Interfaces\Services\SubGroupserviceInterface;
use App\Models\SubGroups;
use App\Repositories\GenericRepository;
use App\Shared\Constants\StatusResponse;
use App\Shared\Handler\Result;
use Illuminate\Support\Facades\Validator;

class SubGroupservice implements SubGroupserviceInterface
{
    /**
     * Create a new class instance.
     */
    private $SubGroupRepository;
    private $genericRepository;
    public function __construct(SubGroupRepositoryInterface $SubGroupRepository)
    {
        //
        $this->SubGroupRepository = $SubGroupRepository;
        $this->genericRepository = new GenericRepository(new SubGroups);
    }


    public function getAllSubGroups()
    {
        $result = $this->SubGroupRepository->getAll();
        return Result::success($result, 'Get all Sub groups Successfully', StatusResponse::HTTP_OK);
    }

    public function getSubGroupById($id)
    {
        $result = $this->SubGroupRepository->getById($id);

        if (!$result) {
            return Result::error("SubGroup not found with this Id {$id}", StatusResponse::HTTP_NOT_FOUND);
        }

        return Result::success($result, 'Sub group is found Successfully by Id', StatusResponse::HTTP_OK);
    }

    public function createSubGroup(array $data)
    {
        $validator = Validator::make($data, (new SubGroupRequest())->rules());

        if ($validator->fails()) {
            return Result::error('Validation failed', 422, $validator->errors());
        }
        $result = $this->SubGroupRepository->create($data);

        if (!$result) {
            return Result::error('Failed in creating Sub gourps', StatusResponse::HTTP_INTERNAL_SERVER_ERROR);
        }

        return Result::success($result, 'Sub is Created Successfully', StatusResponse::HTTP_CREATED);
    }

    public function getSubByTheoGroup($groupId)
    {
        $result = $this->SubGroupRepository->getByTheoGroupId($groupId);

        if (!$result) {
            return Result::error("SubGroup not found with this Id {$groupId}", StatusResponse::HTTP_NOT_FOUND);
        }

        return Result::success($result, 'Sub group is found Successfully by groupId', StatusResponse::HTTP_OK);
    }

    public function getSubByInstructor($instructorId)
    {
        $result = $this->SubGroupRepository->getByInstructorId($instructorId);

        if (!$result) {
            return Result::error("SubGroup not found with this Id {$instructorId}", StatusResponse::HTTP_NOT_FOUND);
        }

        return Result::success($result, 'Sub group is found Successfully by InstructorId', StatusResponse::HTTP_OK);
    }

    public function updateSubGroup($id, array $data)
    {
        $validator = Validator::make($data, [
            'name' => "required|string|unique:sub_groups,name,{$id}",
            'groups_id' => 'required|integer|exists:groups,id',
            'instructor_id' => 'required|integer|exists:instructors,id',
        ]);

        if ($validator->fails()) {
            // Include detailed error messages
            return Result::error('Validation failed', 422, $validator->errors());
        }

        $updatedSubgroup = $this->genericRepository->update($id, $data);

        if (!$updatedSubgroup) {
            return Result::error('Failed to update Course', StatusResponse::HTTP_BAD_REQUEST);
        }

        return Result::success($updatedSubgroup, 'Sub Updated Successfully', StatusResponse::HTTP_OK);
    }


    public function deleteSubGroup($id)
    {
        $result = $this->genericRepository->delete($id);

        return Result::success($result, 'Sub group is Deleted Successfully', StatusResponse::HTTP_OK);
    }
}
