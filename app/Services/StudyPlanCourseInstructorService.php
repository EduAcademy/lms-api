<?php

namespace App\Services;

use App\Contracts\StudyPlanCourseInstructorRepositoryInterface;
use App\Http\Requests\StudyPlanCourseInstructorRequest;
use App\Interfaces\Services\StudyPlanCourseInstructorServiceInterface;
use App\Models\StudyPlanCourseInstructor;
use App\Repositories\GenericRepository;
use App\Shared\Constants\StatusResponse;
use App\Shared\Handler\Result;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class StudyPlanCourseInstructorService implements StudyPlanCourseInstructorServiceInterface
{
    /**
     * Create a new class instance.
     */
    private $spCInstructorRepository;
    private $genericRepository;
    public function __construct(StudyPlanCourseInstructorRepositoryInterface $spCInstructorRepository)
    {
        //
        $this->spCInstructorRepository = $spCInstructorRepository;
        $this->genericRepository = new GenericRepository(new StudyPlanCourseInstructor);
    }

    public function getAllSpCInstructors()
    {
        $result = $this->spCInstructorRepository->getAll();

        return Result::success($result, 'Get All StudyPlanCourseInstructors', StatusResponse::HTTP_OK);
    }

    public function getSpCInstructorById($id)
    {
        $result = $this->spCInstructorRepository->getById($id);

        if (!$result) {
            return Result::error("StudyPlanCourseInstructors Course not found with this Id {$id}", StatusResponse::HTTP_NOT_FOUND);
        }

        return Result::success($result, 'Found StudyPlanCourseInstructors Successfully', StatusResponse::HTTP_OK);
    }

    public function createSpCInstructor(array $data)
    {
        $validator = Validator::make($data, (new StudyPlanCourseInstructorRequest())->rules());

        if ($validator->fails()) {
            return Result::error('Validation failed', 422, $validator->errors());
        }

        $result = $this->spCInstructorRepository->create($data);

        return Result::success($result, 'StudyPlanCourseInstructor is created Successfully', StatusResponse::HTTP_OK);
    }

    public function getSpCInstructorBySpCourseId($stupCId)
    {
        $result = $this->spCInstructorRepository->getByStudyplanCourseId($stupCId);

        if (!$result) {
            return Result::error("StudyPlanCourseInstructor Course not found with this Id {$stupCId}", StatusResponse::HTTP_NOT_FOUND);
        }

        return Result::success($result, 'Found StudyPlanCourseInstructor Successfully', StatusResponse::HTTP_OK);
    }

    public function getSpCInstructorByGroupId($groupId)
    {
        $result = $this->spCInstructorRepository->getByGroupId($groupId);

        if (!$result) {
            return Result::error("StudyPlanCourseInstructor Course not found with this Id {$groupId}", StatusResponse::HTTP_NOT_FOUND);
        }

        return Result::success($result, 'Found StudyPlanCourseInstructor Successfully', StatusResponse::HTTP_OK);
    }

    public function getSpCInstructorByInstruId($instructorId)
    {
        $result = $this->spCInstructorRepository->getByInstructorId($instructorId);

        if (!$result) {
            return Result::error("StudyPlanCourseInstructor Course not found with this Id {$instructorId}", StatusResponse::HTTP_NOT_FOUND);
        }

        return Result::success($result, 'Found StudyPlanCourseInstructor Successfully', StatusResponse::HTTP_OK);
    }

    public function updateSpCInstructor($id, array $data)
    {

        $validator = Validator::make($data, [
            'study_plan_course_id' => 'required|integer|exists:study_plan_courses,id',
            'group_id' => 'required|integer|exists:groups,id',
            'instructor_id' => 'required|integer|exists:instructors,id',
        ]);

        if ($validator->fails()) {
            // Include detailed error messages
            return Result::error('Validation failed', 422, $validator->errors());
        }

        $result = $this->genericRepository->update($id, $data);

        if (!$result) {
            return Result::error('Failed to update StudyPlanCourseInstructor', StatusResponse::HTTP_BAD_REQUEST);
        }

        return Result::success($result, 'StudyPlanCourseInstructor Updated Successfully', StatusResponse::HTTP_OK);
    }

    public function deleteSpCInstructor($id)
    {
        $result = $this->genericRepository->delete($id);

        return Result::success($result, 'StudyPlanCourseInstructor is Deleted Successfully', StatusResponse::HTTP_OK);
    }

    public function getDepartmentsByInstructorId($instructorId)
    {
        $result = $this->spCInstructorRepository->getDepartmentsByInstructorId($instructorId);
        return Result::success($result, 'Get All departments related to the logged in instructor', StatusResponse::HTTP_OK);
    }

    public function getGroupByInstructorCourse($instructorId, $courseId, $levelId)
    {
        $result = $this->spCInstructorRepository->getGroupByInstructorCourse($instructorId, $courseId, $levelId);
        return Result::success($result, 'Get All groups related to the logged in instructor and his course and level', StatusResponse::HTTP_OK);
    }

    public function getLevelsByInstructorAndCourse($instructorId, $courseId)
    {
        $result = $this->spCInstructorRepository->getLevelsByInstructorAndCourse($instructorId, $courseId);
        return Result::success($result, 'Get All levels related to the logged in instructor and his course', StatusResponse::HTTP_OK);
    }
}
