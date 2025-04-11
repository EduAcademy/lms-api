<?php

namespace App\Services;

use App\Contracts\StudyPlanRepositoryInterface;
use App\Http\Requests\StudyPlanRequest;
use App\Interfaces\Services\StudyPlanServiceInterface;
use App\Models\StudyPlan;
use App\Repositories\GenericRepository;
use App\Shared\Constants\StatusResponse;
use App\Shared\Handler\Result;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class StudyPlanService implements StudyPlanServiceInterface
{
    /**
     * Create a new class instance.
     */

    private $studyplanRepository;
    private $genericRepository;

    public function __construct(StudyPlanRepositoryInterface $studyplanRepository)
    {
        //
        $this->studyplanRepository = $studyplanRepository;
        $this->genericRepository = new GenericRepository(new StudyPlan);
    }

    public function getAllStudyPlans()
    {
        $result = $this->studyplanRepository->getAll();

        return Result::success($result, 'Get All Study Plans Successfully', StatusResponse::HTTP_OK);
    }

    public function getStudyPlanById($id)
    {
        $result = $this->studyplanRepository->getById($id);

        if (!$result) {
            return Result::error("StudyPlan not found with this Id {$id}", StatusResponse::HTTP_NOT_FOUND);
        }

        return Result::success($result, 'Found StudyPlan Successfully', StatusResponse::HTTP_OK);
    }

    public function createStudyPlan(array $data)
    {
        $validator = Validator::make($data, (new StudyPlanRequest())->rules());

        if ($validator->fails()) {
            return Result::error('Validation failed', 422, $validator->errors());
        }

        $result = $this->studyplanRepository->create($data);

        return Result::success($result, 'StudyPlan is created Successfully', StatusResponse::HTTP_OK);
    }

    public function updateStudyPlan($id, array $data)
    {
        Log::info('Incoming Data:', $data);

        $validator = Validator::make($data, [
            'name' => 'required|string',
            'number' => 'required|integer',
            'start_date' => 'required|date',
        ]);

        if ($validator->fails()) {
            Log::error('Validation Errors:', $validator->errors()->toArray()); // Log validation errors
            return Result::error('Validation failed', 422, $validator->errors());
        }

        $result = $this->genericRepository->update($id, $data);

        if (!$result) {
            return Result::error('Failed to update Study Plan', StatusResponse::HTTP_BAD_REQUEST);
        }

        return Result::success($result, 'StudyPlan Updated Successfully', StatusResponse::HTTP_OK);
    }

    public function deleteStudyPlan($id)
    {
        $result = $this->genericRepository->delete($id);

        return Result::success($result, 'StudyPlan is Deleted Successfully', StatusResponse::HTTP_OK);
    }
}
