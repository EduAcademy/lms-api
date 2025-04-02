<?php

namespace App\Services;

use App\Contracts\LevelRepositoryInterface;
use App\Interfaces\Services\LevelServiceInterface;
use App\Shared\Constants\MessageResponse;
use App\Shared\Constants\StatusResponse;
use App\Shared\Handler\Result;

class LevelService implements LevelServiceInterface
{
    /**
     * Create a new class instance.
     */
    protected $levelRepo;
    public function __construct(LevelRepositoryInterface $levelRepo)
    {
        //
        $this->levelRepo = $levelRepo;
    }

    public function getLevels($instructorId, $departmentId)
    {
        $result = $this->levelRepo->getLevels($instructorId, $departmentId);

        return Result::success($result, MessageResponse::RETRIEVED_SUCCESSFULLY, StatusResponse::HTTP_OK);
    }
}
