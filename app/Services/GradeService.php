<?php

namespace App\Services;

use App\Contracts\GradeRepositoryInterface;
use App\Interfaces\Services\GradeServiceInterface;
use App\Shared\Constants\StatusResponse;
use App\Shared\Handler\Result;

class GradeService implements GradeServiceInterface
{
    /**
     * Create a new class instance.
     */
    protected $gradeRepositoryInterface;
    public function __construct(GradeRepositoryInterface $gradeRepositoryInterface)
    {
        //
        $this->gradeRepositoryInterface = $gradeRepositoryInterface;
    }


    public function getAll()
    {
        $result = $this->gradeRepositoryInterface->getAll();
        return Result::success($result, 'Get All Grades Successfully', StatusResponse::HTTP_OK);
    }

    public function create(array $data)
    {
        $result = $this->gradeRepositoryInterface->create($data);
        return Result::success($result, 'A new Grade is created successfully', StatusResponse::HTTP_OK);
    }

    public function getByInstructorId($instructorId)
    {
        $result = $this->gradeRepositoryInterface->getByInstructorId($instructorId);
        return Result::success($result, 'Get Grades by instructor Successfully', StatusResponse::HTTP_OK);
    }

    public function getByStudentAndCourse($studentId, $courseId)
    {
        $result = $this->gradeRepositoryInterface->getByStudentAndCourse($studentId, $courseId);
        return Result::success($result, 'Get Grades by Course and Student Successfully', StatusResponse::HTTP_OK);
    }
}
