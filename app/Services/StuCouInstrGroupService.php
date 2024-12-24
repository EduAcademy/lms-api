<?php

namespace App\Services;

use App\Contracts\StuCouInstrGroupRepositoryInterface;
use App\Interfaces\Services\StuCouInstrGroupServiceInterface;
use App\Models\StudentCourseInstructorGroup;
use App\Repositories\GenericRepository;
use App\Shared\Constants\StatusResponse;
use App\Shared\Handler\Result;
use Illuminate\Support\Facades\Validator;

class StuCouInstrGroupService implements StuCouInstrGroupServiceInterface
{
    /**
     * Create a new class instance.
     */
    private $stuCouInstrGroupRepository;
    private $genericRepository;
    public function __construct(StuCouInstrGroupRepositoryInterface $stuCouInstrGroupRepository)
    {
        //
        $this->stuCouInstrGroupRepository = $stuCouInstrGroupRepository;
        $this->genericRepository = new GenericRepository(new StudentCourseInstructorGroup);
    }

    public function getAllStuCouInstrGroups()
    {
        $result = $this->stuCouInstrGroupRepository->getAll();
        return Result::success($result, 'Get all StuCouInstrGroups Successfully', StatusResponse::HTTP_OK);
    }

    public function getStuCouInstrGroupById($id)
    {
        $result = $this->stuCouInstrGroupRepository->getById($id);
        return Result::success($result, 'StuCouInstrGroup is found Successfully by Id', StatusResponse::HTTP_OK);
    }

    public function getStuCouInstrGroupByCourseId($courseId)
    {
        $result = $this->stuCouInstrGroupRepository->getByCourseId($courseId);
        return Result::success($result, 'StuCouInstrGroup is found Successfully by CourseId', StatusResponse::HTTP_OK);
    }

    public function getStuCouInstrGroupByStudentId($studentId)
    {
        $result = $this->stuCouInstrGroupRepository->getByStudentId($studentId);
        return Result::success($result, 'StuCouInstrGroup is found Successfully by StudentId', StatusResponse::HTTP_OK);
    }

    public function getStuCouInstrGroupByInstructorId($instructorId)
    {
        $result = $this->stuCouInstrGroupRepository->getByInstructorId($instructorId);
        return Result::success($result, 'StuCouInstrGroup is found Successfully by Instructor', StatusResponse::HTTP_OK);
    }

    public function getStuCouInstrGroupByTheoGroupId($theogroupId)
    {
        $result = $this->stuCouInstrGroupRepository->getByTheoGroupId($theogroupId);
        return Result::success($result, 'StuCouInstrGroup is found Successfully by TheogroupId', StatusResponse::HTTP_OK);
    }

    public function createStuCouInstrGroup(array $data)
    {
        $validator = Validator::make($data, [
            'student_id' => 'required|integer|exists:students,id',
            'instructor_id' => 'required|integer|exists:instructors,id',
            'course_id' => 'required|integer|exists:courses,id',
            'theoretical_groups_id' => 'required|integer|exists:theoretical_groups,id',
        ]);

        if ($validator->fails()) {
            // Include detailed error messages
            return Result::error('Validation failed', 422, $validator->errors());
        }

        $result = $this->stuCouInstrGroupRepository->create($data);

        Result::success($result, 'StuCouInstrGroup is created Successfully', StatusResponse::HTTP_CREATED);
    }

    public function updateStuCouInstrGroup($id, array $data)
    {
        $validator = Validator::make($data, [
            'student_id' => 'required|integer|exists:students,id',
            'instructor_id' => 'required|integer|exists:instructors,id',
            'course_id' => 'required|integer|exists:courses,id',
            'theoretical_groups_id' => 'required|integer|exists:theoretical_groups,id',
        ]);

        if ($validator->fails()) {
            // Include detailed error messages
            return Result::error('Validation failed', 422, $validator->errors());
        }

        $updatedLab = $this->genericRepository->update($id, $data);

        if (!$updatedLab) {
            return Result::error('Failed to update StuCouInstrGroup', StatusResponse::HTTP_BAD_REQUEST);
        }

        return Result::success($updatedLab, 'StuCouInstrGroup Updated Successfully', StatusResponse::HTTP_OK);
    }


    public function deleteStuCouInstrGroup($id)
    {
        $result = $this->genericRepository->delete($id);

        return Result::success($result, 'StuCouInstrGroup is Deleted Successfully', StatusResponse::HTTP_OK);
    }
}
