<?php

namespace App\Services;

use App\Contracts\GroupRepositoryInterface;
use App\Http\Requests\GroupRequest;
use App\Interfaces\Services\GroupserviceInterface;
use App\Models\Groups;
use App\Repositories\GenericRepository;
use App\Shared\Constants\StatusResponse;
use App\Shared\Handler\Result;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class Groupservice implements GroupserviceInterface
{
    /**
     * Create a new class instance.
     */
    private $groupRepository;
    private $genericRepository;
    public function __construct(GroupRepositoryInterface $groupRepository)
    {
        //
        $this->groupRepository = $groupRepository;
        $this->genericRepository = new GenericRepository(new Groups);
    }

    public function getAllGroups()
    {
        $result = $this->groupRepository->getAll();
        return Result::success($result, 'Get all  groups Successfully', StatusResponse::HTTP_OK);
    }

    public function getGroupById($id)
    {
        $result = $this->groupRepository->getById($id);
        if (!$result) {
            return Result::error("Group not found with this Id {$id}", StatusResponse::HTTP_NOT_FOUND);
        }
        return Result::success($result, 'Found  group Successfully', StatusResponse::HTTP_OK);
    }

    public function createGroup(array $data)
    {
        $validator = Validator::make($data, (new GroupRequest())->rules());

        if ($validator->fails()) {
            Log::error('Validation Errors:', $validator->errors()->toArray());
            return Result::error('Validation failed', 422, $validator->errors());
        }
        $result = $this->groupRepository->create($data);
        if (!$result) {
            return Result::error('Failed in creating Group', StatusResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
        return Result::success($result, 'Group is Created Successfully', StatusResponse::HTTP_CREATED);
    }

    public function updateGroup($id, array $data)
    {
        $validator = Validator::make($data, [
            'name' => "required|string|unique:groups,name,{$id}",
        ]);

        if ($validator->fails()) {
            // Include detailed error messages
            return Result::error('Validation failed', 422, $validator->errors());
        }

        $updatedTheo = $this->genericRepository->update($id, $data);

        if (!$updatedTheo) {
            return Result::error('Failed to update Course', StatusResponse::HTTP_BAD_REQUEST);
        }

        return Result::success($updatedTheo, 'Theo group Updated Successfully', StatusResponse::HTTP_OK);
    }


    public function deleteGroup($id)
    {
        $result = $this->genericRepository->delete($id);

        return Result::success($result, 'Theo group is Deleted Successfully', StatusResponse::HTTP_OK);
    }
}
