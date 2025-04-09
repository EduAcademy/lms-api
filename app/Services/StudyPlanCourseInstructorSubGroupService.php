<?php

namespace App\Services;

use App\Contracts\StudyPlanCourseInstructorSubGroupRepositoryInterface;
use App\Http\Requests\StudyPlanCourseInstructorSubGroupRequest;
use App\Interfaces\Services\StudyPlanCourseInstructorSubGroupServiceInterface;
use App\Models\StudyPlanCourseInstructorSubGroup;
use App\Repositories\GenericRepository;
use App\Shared\Constants\StatusResponse;
use App\Shared\Handler\Result;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class StudyPlanCourseInstructorSubGroupService implements StudyPlanCourseInstructorSubGroupServiceInterface
{
    /**
     * Create a new class instance.
     */
    private $spcInssubGroupRepository;
    private $genericRepository;
    public function __construct(StudyPlanCourseInstructorSubGroupRepositoryInterface $spcInssubGroupRepository)
    {
        //
        $this->spcInssubGroupRepository = $spcInssubGroupRepository;
        $this->genericRepository = new GenericRepository(new StudyPlanCourseInstructorSubGroup);
    }

    public function getAllSpCInstSubGrou()
    {
        $result = $this->spcInssubGroupRepository->getAll();

        return Result::success($result, 'Get All StudyPlanCInsSubGroups Successfully', StatusResponse::HTTP_OK);
    }

    public function getSpCInstSubGrouById($id)
    {
        $result = $this->spcInssubGroupRepository->getById($id);

        if (!$result) {
            return Result::error("StudyPlanCInsSubGroup Course not found with this Id {$id}", StatusResponse::HTTP_NOT_FOUND);
        }

        return Result::success($result, 'Found StudyPlanCInsSubGroup Successfully by Id', StatusResponse::HTTP_OK);
    }

    public function createSpCInstSubGrou(array $data)
    {
        $validator = Validator::make($data, (new StudyPlanCourseInstructorSubGroupRequest())->rules());

        if ($validator->fails()) {
            return Result::error('Validation failed', 422, $validator->errors());
        }

        $result = $this->spcInssubGroupRepository->create($data);

        return Result::success($result, 'StudyPlanCInsSubGroup is created Successfully', StatusResponse::HTTP_OK);
    }

    public function getSpCInstSubGrouBySpCInstId($stupCInsId)
    {
        $result = $this->spcInssubGroupRepository->getByStudyplanCourseInstructorId($stupCInsId);

        if (!$result) {
            return Result::error("StudyPlanCInsSubGroup Course not found with this Id {$stupCInsId}", StatusResponse::HTTP_NOT_FOUND);
        }

        return Result::success($result, 'Found StudyPlanCInsSubGroup Successfully by stupCInsId', StatusResponse::HTTP_OK);
    }

    public function getSpCInstSubGrouBySubgroupId($sub_groupId)
    {
        $result = $this->spcInssubGroupRepository->getBySubgroupId($sub_groupId);

        if (!$result) {
            return Result::error("StudyPlanCInsSubGroup Course not found with this Id {$sub_groupId}", StatusResponse::HTTP_NOT_FOUND);
        }

        return Result::success($result, 'Found StudyPlanCInsSubGroup Successfully by sub_groupId', StatusResponse::HTTP_OK);
    }

    public function getSpCInstSubGrouByInstrId($instructorId)
    {
        $result = $this->spcInssubGroupRepository->getByInstructorId($instructorId);

        if (!$result) {
            return Result::error("StudyPlanCInsSubGroup Course not found with this Id {$instructorId}", StatusResponse::HTTP_NOT_FOUND);
        }

        return Result::success($result, 'Found StudyPlanCInsSubGroup Successfully by instructorId', StatusResponse::HTTP_OK);
    }

    public function updateSpCInstSubGrou($id, array $data)
    {
        $validator = Validator::make($data, [
            'spc_instructor_id' => 'required|integer|exists:spc_instructors,id',
            'sub_group_id' => 'required|integer|exists:sub_groups,id',
            'instructor_id' => 'required|integer|exists:instructors,id'
        ]);

        if ($validator->fails()) {
            // Include detailed error messages
            return Result::error('Validation failed', 422, $validator->errors());
        }

        $result = $this->genericRepository->update($id, $data);

        if (!$result) {
            return Result::error('Failed to update StudyPlanCInsSubGroup', StatusResponse::HTTP_BAD_REQUEST);
        }

        return Result::success($result, 'StudyPlanCInsSubGroup Updated Successfully', StatusResponse::HTTP_OK);
    }

    public function deleteSpCInstSubGrou($id)
    {
        $result = $this->genericRepository->delete($id);

        return Result::success($result, 'StudyPlanCInsSubGroup is Deleted Successfully', StatusResponse::HTTP_OK);
    }

    public function getCoursesBySubGroupId($subGroupId)
    {
        $result = $this->spcInssubGroupRepository->getCoursesBySubGroupId($subGroupId);

        if (!$result) {
            return Result::error("Course not found with this SubgroupId {$subGroupId}", StatusResponse::HTTP_NOT_FOUND);
        }

        return Result::success($result, 'Found Course Successfully by SubgroupId', StatusResponse::HTTP_OK);
    }

    public function getSubGroupsByCourseLevel($courseId, $levelId)
    {
        $result = $this->spcInssubGroupRepository->getSubGroupsByCourseLevel($courseId, $levelId);

        if (!$result) {
            return Result::error("Subgroup not found with this Course, Level and Sroup", StatusResponse::HTTP_NOT_FOUND);
        }

        return Result::success($result, 'Found Subgroup Successfully by Course, Level and Group', StatusResponse::HTTP_OK);
    }
}
