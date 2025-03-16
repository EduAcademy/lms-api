<?php

namespace App\Services;

use App\Contracts\InstructorRepositoryInterface;
use App\Enums\RoleType;
use App\Http\Requests\InstructorRequest;
use App\Interfaces\Services\InstructorServiceInterface;
use App\Interfaces\Services\UserServiceInterface;
use App\Models\Instructor;
use App\Repositories\GenericRepository;
use App\Shared\Constants\StatusResponse;
use App\Shared\Handler\Result;
use Illuminate\Support\Facades\Validator;

class InstructorService implements InstructorServiceInterface
{
    protected $instructorRepository;
    private $userService;
    private $genericRepository;
    public function __construct(
        InstructorRepositoryInterface $instructorRepository,
        UserServiceInterface $userService,
    ) {
        $this->instructorRepository = $instructorRepository;
        $this->userService = $userService;
        $this->genericRepository = new GenericRepository(new Instructor);
    }

    public function getAllInstructors()
    {
        $result = $this->instructorRepository->getAll();
        return Result::success($result, 'Got All Instructors Successfully', StatusResponse::HTTP_OK);
    }

    public function getInstructorById($id)
    {
        $result = $this->instructorRepository->getById($id);

        if ($result) {
            return Result::success($result, 'Instructor is found Successfully', StatusResponse::HTTP_OK);
        }
        return Result::error('Can not found Instructor with this Id', StatusResponse::HTTP_NOT_FOUND);
    }

    public function createInstructor(array $data)
    {
        $validator = Validator::make($data, (new InstructorRequest())->rules());

        if ($validator->fails()) {
            return Result::error('Validation failed', 422, $validator->errors());
        }

        $user_id = $data['user_id'];

        $check_role = $this->userService->isRoleAllowed($user_id, RoleType::Instructor->toString());

        if ($check_role == false) {
            return Result::error('Failed in creating Instructor because of Role', StatusResponse::HTTP_INTERNAL_SERVER_ERROR);
        }

        $result = $this->instructorRepository->create($data);

        if (!$result) {
            return Result::error('Failed in creating Instructor', StatusResponse::HTTP_INTERNAL_SERVER_ERROR);
        }

        return Result::success($result, 'Instructor is Created Successfully', StatusResponse::HTTP_CREATED);
    }

    public function updateInstructor($id, array $data)
    {
        $validator = Validator::make($data, [
            'professional_title' => 'required|string|max:255',
            'about_me' => 'nullable|string',
            'social_links' => 'nullable|url',
            'user_id' => 'required|integer|exists:users,id',
        ]);

        if ($validator->fails()) {
            return Result::error('Failed in updating Instructor', StatusResponse::HTTP_INTERNAL_SERVER_ERROR);
        }

        $user_id = $data['user_id'];

        $check_role = $this->userService->isRoleAllowed($user_id, RoleType::Instructor->toString());

        if ($check_role == false) {
            return Result::error('Failed in creating Instructor because of Role', StatusResponse::HTTP_INTERNAL_SERVER_ERROR);
        }

        $result = $this->genericRepository->update($id, $data);

        if (!$result) {
            return Result::error('Failed in udapting Instructor', StatusResponse::HTTP_INTERNAL_SERVER_ERROR);
        }

        return Result::success($result, 'Instructor is updated Successfully', StatusResponse::HTTP_OK);
    }

    public function deleteInstructor($id)
    {
        $result = $this->genericRepository->delete($id);

        return Result::success($result, 'Instructor is deleted Successfully', StatusResponse::HTTP_OK);
    }


    public function count(): int
    {
        return $this->instructorRepository->count();
    }
}
