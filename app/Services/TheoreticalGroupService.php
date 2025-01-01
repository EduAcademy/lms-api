<?php

namespace App\Services;

use App\Contracts\TheoreticalGroupRepositoryInterface;
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
    private $theoreticalGroupRepository;
    private $genericRepository;
    public function __construct(TheoreticalGroupRepositoryInterface $theoreticalGroupRepository)
    {
        //
        $this->theoreticalGroupRepository = $theoreticalGroupRepository;
        $this->genericRepository = new GenericRepository(new Groups);
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
        $validator = Validator::make($data, (new Groups())->rules());

        if ($validator->fails()) {
            Log::error('Validation Errors:', $validator->errors()->toArray());
            return Result::error('Validation failed', 422, $validator->errors());
        }
        $result = $this->theoreticalGroupRepository->create($data);
        if (!$result) {
            return Result::error('Failed in creating TheoreticalGroup', StatusResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
        return Result::success($result, 'Theo Group is Created Successfully', StatusResponse::HTTP_CREATED);
    }

    public function updateLabGroup($id, array $data)
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


    public function deleteLabGroup($id)
    {
        $result = $this->genericRepository->delete($id);

        return Result::success($result, 'Theo group is Deleted Successfully', StatusResponse::HTTP_OK);
    }
}
