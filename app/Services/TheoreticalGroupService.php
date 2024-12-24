<?php

namespace App\Services;

use App\Contracts\TheoreticalGroupRepositoryInterface;
use App\Interfaces\Services\TheoreticalGroupServiceInterface;
use App\Models\TheoreticalGroups;
use App\Repositories\GenericRepository;
use App\Shared\Constants\StatusResponse;
use App\Shared\Handler\Result;
use Illuminate\Support\Facades\Validator;

class TheoreticalGroupService implements TheoreticalGroupServiceInterface
{
    /**
     * Create a new class instance.
     */
    private $theoreticalGroupRepository;
    private $genericRepository;
    public function __construct(TheoreticalGroupRepositoryInterface $theoreticalGroupRepository)
    {
        //
        $this->theoreticalGroupRepository = $theoreticalGroupRepository;
        $this->genericRepository = new GenericRepository(new TheoreticalGroups);
    }

    public function getAllTheoGroups()
    {
        $result = $this->theoreticalGroupRepository->getAll();
        return Result::success($result, 'Get all Theo groups Successfully', StatusResponse::HTTP_OK);
    }

    public function getTheoGroupById($id)
    {
        $result = $this->theoreticalGroupRepository->getById($id);
        return Result::success($result, 'Found Theo group Successfully', StatusResponse::HTTP_OK);
    }

    public function createTheoGroup(array $data)
    {

        $validator = Validator::make($data, [
            'name' => 'required|string|unique:theoretical_groups,name',
        ]);

        if ($validator->fails()) {
            return Result::error('Validation failed', 422, $validator->errors());
        }
        $result = $this->theoreticalGroupRepository->create($data);
        return Result::success($result, 'Theo Group is Created Successfully', StatusResponse::HTTP_CREATED);
    }

    public function updateLabGroup($id, array $data)
    {
        $validator = Validator::make($data, [
            'name' => "required|string|unique:theoretical_groups,name,{$id}",
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


    public function deleteLabGroup($id)
    {
        $result = $this->genericRepository->delete($id);

        return Result::success($result, 'Theo group is Deleted Successfully', StatusResponse::HTTP_OK);
    }
}
