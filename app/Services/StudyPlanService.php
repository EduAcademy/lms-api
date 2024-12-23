<?php

namespace App\Services;

use App\Contracts\StudyPlanRepositoryInterface;
use App\Interfaces\Services\StudyPlanServiceInterface;
use App\Models\Course;
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

        return Result::success($result, 'Found StudyPlan Successfully', StatusResponse::HTTP_OK);
    }

    public function getStudyPlanByDeptId($departmentId)
    {
        $result = $this->studyplanRepository->getByDepartmentId($departmentId);
        return Result::success($result, 'Found Study Plan by Department Successfully', StatusResponse::HTTP_OK);
    }

    public function getStudyPlanByCourseId($courseId)
    {

        $result = $this->studyplanRepository->getByCourseId($courseId);
        return Result::success($result, 'Found Study Plan by Course Successfully', StatusResponse::HTTP_OK);
    }

    public function createStudyPlan(array $data)
    {
        $validator = Validator::make($data, [
            'study_plan_no' => 'required|integer|unique:study_plans,study_plan_no',
            'level' => 'required|integer',
            'semester' => 'required|integer',
            'issued_at' => 'required|date',
            'department_id' => 'required|integer|exists:departments,id',
            'courses' => 'required|array',
            'courses.*.course_id' => 'required|integer|exists:courses,id',
        ]);

        if ($validator->fails()) {
            return Result::error('Validation failed', 422, $validator->errors());
        }

        $result = $this->studyplanRepository->create($data, $data['courses']);

        return Result::success($result, 'StudyPlan is created Successfully', StatusResponse::HTTP_OK);
    }

    public function updateStudyPlan($id, array $data)
    {
        Log::info('Incoming Data:', $data);

        $validator = Validator::make($data, [
            'study_plan_no' => "required|integer", // Exclude current record
            'level' => 'required|integer',
            'semester' => 'required|integer',
            'issued_at' => 'required|date',
            'department_id' => 'required|integer|exists:departments,id',
            'course_id' => 'required|integer|exists:courses,id',
        ]);

        if ($validator->fails()) {
            Log::error('Validation Errors:', $validator->errors()->toArray()); // Log validation errors
            return Result::error('Validation failed', 422, $validator->errors());
        }

        $updatedCourse = $this->genericRepository->update($id, $data);

        if (!$updatedCourse) {
            return Result::error('Failed to update Study Plan', StatusResponse::HTTP_BAD_REQUEST);
        }

        return Result::success($updatedCourse, 'StudyPlan Updated Successfully', StatusResponse::HTTP_OK);
    }




    public function deleteStudyPlan($id)
    {
        $result = $this->genericRepository->delete($id);

        return Result::success($result, 'StudyPlan is Deleted Successfully', StatusResponse::HTTP_OK);
    }
}
