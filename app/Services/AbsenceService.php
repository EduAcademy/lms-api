<?php

namespace App\Services;

use App\Contracts\AbsenceRepositoryInterface;
use App\Helpers\ArrayHelper;
use App\Http\Requests\AbsenceRequest;
use App\Interfaces\Services\AbsenceServiceInterface;
use App\Shared\Constants\StatusResponse;
use App\Shared\Handler\Result;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class AbsenceService implements AbsenceServiceInterface
{
    /**
     * Create a new class instance.
     */

    protected $absenceRepositoryInterface;
    public function __construct(AbsenceRepositoryInterface $absenceRepositoryInterface)
    {
        //
        $this->absenceRepositoryInterface = $absenceRepositoryInterface;
    }

    protected function maptoArray($items, $key)
    {
        return array_map(function ($item) use ($key) {
            return [$key => $item];
        }, $items);
    }

    public function createAbsence(array $data)
    {
        $validator = Validator::make($data, (new AbsenceRequest())->rules());

        if ($validator->fails()) {
            return Result::error('Validation failed', 422, $validator->errors());
        }

        $students = $this->maptoArray($data['student_id'], 'student_id');

        try {
            $result = $this->absenceRepositoryInterface->create($data, $students);

            if (!$result) {
                return Result::error('Failed to create Absence', StatusResponse::HTTP_INTERNAL_SERVER_ERROR);
            }

            return Result::success($result, 'Absence created successfully', StatusResponse::HTTP_OK);
        } catch (\Exception $e) {
            Log::error('Failed to create Absence: ' . $e->getMessage());
            return Result::error('An error occurred while creating Absence', StatusResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getAllAbsence()
    {
        $result = $this->absenceRepositoryInterface->getAll();
        return Result::success($result, 'Get All Absence', StatusResponse::HTTP_OK);
    }

    public function getAbsenceCountByStudentAndCourse($studentId, $courseId)
    {
        $result = $this->absenceRepositoryInterface->getAbsenceCountByStudentAndCourse($studentId, $courseId);
        return Result::success($result, 'Get counts of student absence and in which course', StatusResponse::HTTP_OK);
    }

}
