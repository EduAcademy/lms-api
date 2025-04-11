<?php

namespace App\Services;

use App\Contracts\CourseRepositoryInterface;
use App\Http\Requests\CourseRequest;
use App\Interfaces\Services\CourseServiceInterface;
use App\Models\Course;
use App\Repositories\GenericRepository;
use App\Shared\Constants\StatusResponse;
use App\Shared\Handler\Result;
use Illuminate\Support\Facades\Validator;

class CourseService implements CourseServiceInterface
{
    /**
     * Create a new class instance.
     */

    private $courseRepository;
    private $genericRepository;

    public function __construct(CourseRepositoryInterface $courseRepository)
    {
        $this->courseRepository = $courseRepository;
        $this->genericRepository = new GenericRepository(new Course);
    }


    public function getAllCourses()
    {
        $result = $this->courseRepository->getAll();

        return Result::success($result, 'Get all courses Successfully', StatusResponse::HTTP_OK);
    }

    public function createCourse(array $data)
    {
        $validator = Validator::make($data, (new CourseRequest())->rules());

        if ($validator->fails()) {
            return Result::error('Validation failed', 422, $validator->errors());
        }
        $result = $this->courseRepository->create($data);

        if(!$result)
        {
            return Result::error('Failed in creating course', StatusResponse::HTTP_INTERNAL_SERVER_ERROR);
        }

        return Result::success($result, 'Course is Created Successfully', StatusResponse::HTTP_CREATED);
    }

    public function getCourseById($id)
    {
        $result = $this->courseRepository->getbyId($id);

        if (!$result) {
            return Result::error("Course not found with this Id {$id}", StatusResponse::HTTP_NOT_FOUND);
        }

        return Result::success($result, 'Course found Successfully by Id', StatusResponse::HTTP_OK);
    }

    public function getCourseByDepartmentId($departmentId)
    {
        $result = $this->courseRepository->getbyDepartmentId($departmentId);

        if (!$result) {
            return Result::error("Course not found with this Id {$departmentId}", StatusResponse::HTTP_NOT_FOUND);
        }

        return Result::success($result, 'Course found Successfully by DepartmentId', StatusResponse::HTTP_OK);
    }

    public function updateCourse($id, array $data)
    {
        $validator = Validator::make($data, [
            'name' => "required|string|unique:courses,name,{$id}",
            'description' => 'nullable|string',
            'course_code' => 'required|string|min:2',
            // 'course_hours' => 'required|integer',
            'type' => 'required|in:core,elective',
            'group_hours' => 'required|integer',
            'sub_group_hours' => 'required|integer',
        ]);

        if ($validator->fails()) {
            // Include detailed error messages
            return Result::error('Validation failed', 422, $validator->errors());
        }

        $updatedCourse = $this->genericRepository->update($id, $data);

        if (!$updatedCourse) {
            return Result::error('Failed to update Course', StatusResponse::HTTP_BAD_REQUEST);
        }

        return Result::success($updatedCourse, 'Course Updated Successfully', StatusResponse::HTTP_OK);
    }


    public function deleteCourse($id)
    {
        $result = $this->genericRepository->delete($id);

        return Result::success($result, 'Course is Deleted Successfully', StatusResponse::HTTP_OK);
    }
}
