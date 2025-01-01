<?php

namespace App\Services;

use App\Contracts\LabGroupRepositoryInterface;
use App\Http\Requests\LabGroupRequest;
use App\Interfaces\Services\LabGroupServiceInterface;
use App\Models\LabGroups;
use App\Repositories\GenericRepository;
use App\Shared\Constants\StatusResponse;
use App\Shared\Handler\Result;
use Illuminate\Support\Facades\Validator;

class LabGroupService implements LabGroupServiceInterface
{
    /**
     * Create a new class instance.
     */
    private $labGroupRepository;
    private $genericRepository;
    public function __construct(LabGroupRepositoryInterface $labGroupRepository)
    {
        //
        $this->labGroupRepository = $labGroupRepository;
        $this->genericRepository = new GenericRepository(new LabGroups);
    }


    public function getAllLabGroup()
    {
        $result = $this->labGroupRepository->getAll();
        return Result::success($result, 'Get all Lab groups Successfully', StatusResponse::HTTP_OK);
    }

    public function getLabById($id)
    {
        $result = $this->labGroupRepository->getById($id);
        return Result::success($result, 'Lab is found Successfully by Id', StatusResponse::HTTP_OK);
    }

    public function createLabGroup(array $data)
    {
        $validator = Validator::make($data, (new LabGroupRequest())->rules());

        if ($validator->fails()) {
            return Result::error('Validation failed', 422, $validator->errors());
        }
        $result = $this->labGroupRepository->create($data);

        if(!$result)
        {
            return Result::error('Failed in creating Lab gourps', StatusResponse::HTTP_INTERNAL_SERVER_ERROR);
        }

        return Result::success($result, 'Lab is Created Successfully', StatusResponse::HTTP_CREATED);
    }

    public function getLabByTheoGroup($theogroupId)
    {
        $result = $this->labGroupRepository->getByTheoGroupId($theogroupId);
        return Result::success($result, 'Lab is found Successfully by TheogroupId', StatusResponse::HTTP_OK);
    }

    public function getLabByInstructor($instructorId)
    {
        $result = $this->labGroupRepository->getByInstructorId($instructorId);
        return Result::success($result, 'Lab is found Successfully by InstructorId', StatusResponse::HTTP_OK);
    }

    public function updateLabGroup($id, array $data)
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

        $updatedLab = $this->genericRepository->update($id, $data);

        if (!$updatedLab) {
            return Result::error('Failed to update Course', StatusResponse::HTTP_BAD_REQUEST);
        }

        return Result::success($updatedLab, 'Lab Updated Successfully', StatusResponse::HTTP_OK);
    }


    public function deleteLabGroup($id)
    {
        $result = $this->genericRepository->delete($id);

        return Result::success($result, 'Lab is Deleted Successfully', StatusResponse::HTTP_OK);
    }

}
