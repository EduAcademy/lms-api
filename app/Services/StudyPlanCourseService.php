<?php

namespace App\Services;

use App\Contracts\StudyPlanCourseRepositoryInterface;
use App\Helpers\ArrayHelper;
use App\Interfaces\Services\StudyPlanCourseServiceInterface;
use App\Http\Requests\StudyPlanCourseRequest;
use App\Models\StudyPlanCourse;
use App\Repositories\GenericRepository;
use App\Shared\Constants\StatusResponse;
use App\Shared\Handler\Result;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class StudyPlanCourseService implements StudyPlanCourseServiceInterface
{
    /**
     * Create a new class instance.
     */
    private $sPCourseRepository;
    private $genericRepository;
    public function __construct(StudyPlanCourseRepositoryInterface $sPCourseRepository)
    {
        //
        $this->sPCourseRepository = $sPCourseRepository;
        $this->genericRepository = new GenericRepository(new StudyPlanCourse);
    }

    public function getAllStudyPlanCourses()
    {
        $result = $this->sPCourseRepository->getAll();

        return Result::success($result, 'Get All Study Plan Courses Successfully', StatusResponse::HTTP_OK);
    }

    public function getStudyPlanCourseById($id)
    {
        $result = $this->sPCourseRepository->getById($id);

        if (!$result) {
            return Result::error("StudyPlanCourse Course not found with this Id {$id}", StatusResponse::HTTP_NOT_FOUND);
        }

        return Result::success($result, 'Found StudyPlanCourse Successfully', StatusResponse::HTTP_OK);
    }

    public function createStudyPlanCourse(array $data)
    {
        $validator = Validator::make($data, (new StudyPlanCourseRequest())->rules());

        if ($validator->fails()) {
            return Result::error('Validation failed', 422, $validator->errors());
        }

        $courses = ArrayHelper::maptoArray($data['course_id'], 'course_id');

        try {
            $result = $this->sPCourseRepository->create($data, $courses);

            if (!$result) {
                return Result::error('Failed to create StudyPlanCourses', StatusResponse::HTTP_INTERNAL_SERVER_ERROR);
            }

            return Result::success($result, 'StudyPlanCourses created successfully', StatusResponse::HTTP_OK);
        } catch (\Exception $e) {
            Log::error('Failed to create StudyPlanCourses: ' . $e->getMessage());
            return Result::error('An error occurred while creating StudyPlanCourses', StatusResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getStudyPlanCourseByStudyplanId($studyplanId)
    {
        $result = $this->sPCourseRepository->getByStudyplanId($studyplanId);

        if (!$result) {
            return Result::error("StudyPlan Course not found with this Id {$studyplanId}", StatusResponse::HTTP_NOT_FOUND);
        }

        return Result::success($result, 'Found StudyPlanCourse Successfully', StatusResponse::HTTP_OK);
    }

    public function getStudyPlanCourseByDepartmentId($departmentId)
    {
        $result = $this->sPCourseRepository->getByDepartmentId($departmentId);

        if (!$result) {
            return Result::error("StudyPlan Course not found with this Id {$departmentId}", StatusResponse::HTTP_NOT_FOUND);
        }

        return Result::success($result, 'Found StudyPlanCourse Successfully', StatusResponse::HTTP_OK);
    }

    public function getStudyPlanCourseByCourseId($courseId)
    {
        $result = $this->sPCourseRepository->getByCourseId($courseId);

        if (!$result) {
            return Result::error("StudyPlan Course not found with this Id {$courseId}", StatusResponse::HTTP_NOT_FOUND);
        }

        return Result::success($result, 'Found StudyPlanCourse Successfully', StatusResponse::HTTP_OK);
    }

    public function updateStudyPlanCourse($id, array $data)
    {


        $courses_ids = $data['course_id'];

        $data['course_id'] = ArrayHelper::convertArraytoInteger($courses_ids);

        $validator = Validator::make($data, [
            'study_plan_id' => 'required|integer|exists:study_plans,id',
            'department_id' => 'required|integer|exists:departments,id',
            'course_id' => 'required|integer|exists:courses,id',
            'level_id' => 'required|integer|exists:levels,id',
            'semester' => 'required|integer|in:1,2',
        ]);

        if ($validator->fails()) {
            // Include detailed error messages
            return Result::error('Validation failed', 422, $validator->errors());
        }

        $result = $this->genericRepository->update($id, $data);

        if (!$result) {
            return Result::error('Failed to update StudyPlanCourse', StatusResponse::HTTP_BAD_REQUEST);
        }

        return Result::success($result, 'StudyPlanCourse Updated Successfully', StatusResponse::HTTP_OK);
    }

    public function deleteStudyPlanCourse($id)
    {
        $result = $this->genericRepository->delete($id);

        return Result::success($result, 'StudyPlanCourse is Deleted Successfully', StatusResponse::HTTP_OK);
    }
    public function getSemesterByLevelId($levelId)
    {
        //
        $result = $this->sPCourseRepository->getSemesterByLevelId($levelId);

        return $result;
    }
    public function getCoursBySemesterId($department_id, $level_id, $semester)
    {
        //
        $result = $this->sPCourseRepository->getCoursBySemesterId($department_id, $level_id, $semester);

        return $result;
    }
    public function getGroupByCourseid($department_id, $level_id, $semesterId, $courseid)
    {

        $result = $this->sPCourseRepository->getGroupByCourseid($department_id, $level_id, $semesterId, $courseid);

        return $result;

    }
    public function getSubGroupByGroupid($department_id, $level_id, $semesterId, $courseid, $groupid)
    {
        $result = $this->sPCourseRepository->getSubGroupByGroupid($department_id, $level_id, $semesterId, $courseid, $groupid);

        return $result;
    }
    public function getCourseByInstructorId($department_id, $level_id, $semester, $instructorId)
    {
        $result = $this->sPCourseRepository->getCourseByInstructorId($department_id, $level_id, $semester, $instructorId);

        return $result;
    }
}
