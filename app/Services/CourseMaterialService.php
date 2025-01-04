<?php

namespace App\Services;

use App\Contracts\CourseMaterialRepositoryInterface;
use App\Http\Requests\CourseMaterialRequest;
use App\Interfaces\Services\CourseMaterialServiceInterface;
use App\Models\CourseMaterial;
use App\Repositories\GenericRepository;
use App\Shared\Constants\StatusResponse;
use App\Shared\Handler\Result;
use Illuminate\Support\Facades\Validator;

class CourseMaterialService implements CourseMaterialServiceInterface
{
    /**
     * Create a new class instance.
     */
    private $courseMaterialRepository;
    private $genericRepository;
    public function __construct(CourseMaterialRepositoryInterface $courseMaterialRepository)
    {
        //
        $this->courseMaterialRepository = $courseMaterialRepository;
        $this->genericRepository = new GenericRepository(new CourseMaterial);
    }


    public function getAllCourseMaterials()
    {
        $result = $this->courseMaterialRepository->getAll();

        return Result::success($result, 'Get All Materials Successfully', StatusResponse::HTTP_OK);
    }

    public function getCourseMaterialById($id)
    {
        $result = $this->courseMaterialRepository->getById($id);

        if($result)
        {
            return Result::success($result, 'Found the Course Material Successfully', StatusResponse::HTTP_OK);
        }

        return Result::error('Can not found course material with this Id');

    }

    public function getCourseMaterialByCourseId($courseId)
    {
        $result = $this->courseMaterialRepository->getByCourseId($courseId);

        if(count($result) > 0)
        {
            return Result::success($result, 'Found the Course Material Successfully by Course', StatusResponse::HTTP_OK);
        }

        return Result::error('Can not found course material with this Course Id');
    }

    public function getCourseMaterialByInstructorId($instructorId)
    {
        $result = $this->courseMaterialRepository->getByInstructorId($instructorId);


        if(count($result) > 0)
        {
            return Result::success($result, 'Found the Course Material Successfully by Instructor', StatusResponse::HTTP_OK);
        }

        return Result::error('Can not found course material with this Instructor Id');
    }

    public function createCourseMaterial(array $data)
    {
        $validator = Validator::make($data, (new CourseMaterialRequest())->rules());

        if ($validator->fails()) {
            return Result::error('Validation failed', 422, $validator->errors());
        }
        $result = $this->courseMaterialRepository->create($data);

        if (!$result) {
            return Result::error('Failed in creating course material', StatusResponse::HTTP_INTERNAL_SERVER_ERROR);
        }

        return Result::success($result, 'Course Material is Created Successfully', StatusResponse::HTTP_CREATED);
    }

    public function updateCourseMaterial($id, array $data)
    {
        $validator = Validator::make($data, [
            'name' => "required|string",
            'type' => 'required|in:group,sub_group',
            'url' => 'nullable|url',
            'course_id' => 'required|integer|exists:courses,id',
            'instructor_id' => 'required|integer|exists:instructors,id'
        ]);

        if ($validator->fails()) {
            return Result::error('Validation failed', 422, $validator->errors());
        }
        $result = $this->genericRepository->update($id, $data);

        if (!$result) {
            return Result::error('Failed in updating course material', StatusResponse::HTTP_INTERNAL_SERVER_ERROR);
        }

        return Result::success($result, 'Course Material is Updated Successfully', StatusResponse::HTTP_CREATED);
    }

    public function deleteCourseMaterial($id)
    {
        $result = $this->genericRepository->delete($id);

        return Result::success($result, 'Course Material is deleted Successfully', StatusResponse::HTTP_CREATED);
    }
}
