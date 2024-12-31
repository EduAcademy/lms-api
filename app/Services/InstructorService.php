<?php

namespace App\Services;

use App\Contracts\InstructorRepositoryInterface;
use App\Http\Requests\InstructorRequest;
use App\Interfaces\Services\InstructorServiceInterface;
use App\Models\Instructor;
use App\Shared\Constants\StatusResponse;
use App\Shared\Handler\Result;
use Illuminate\Support\Facades\Validator;

class InstructorService implements InstructorServiceInterface
{
    protected $InstructorRepository;

    public function __construct(InstructorRepositoryInterface $InstructorRepository)
    {
        $this->InstructorRepository = $InstructorRepository;
    }

    public function getAll()
    {
        $instructors = Instructor::with('user')->get();
        return $instructors;
    }
    public function findById($id) {}
    public function getInstructorById($id) {}
    public function createInstructor(array $data)
    {
        $validator = Validator::make($data, (new InstructorRequest())->rules());

        if ($validator->fails()) {
            return Result::error('Validation failed', 422, $validator->errors());
        }
        $result = $this->InstructorRepository->createInstructor($data);

        if (!$result) {
            return Result::error('Failed in creating Instructor', StatusResponse::HTTP_INTERNAL_SERVER_ERROR);
        }

        return Result::success($result, 'Instructor is Created Successfully', StatusResponse::HTTP_CREATED);
    }
    public function updateInstructor($id, array $data) {}
    public function deleteInstructor($id) {}
}
