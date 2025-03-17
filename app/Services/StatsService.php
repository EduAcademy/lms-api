<?php

namespace App\Services;

use App\Interfaces\Services\StatsServiceInterface;
use App\Repositories\StudentRepository;
use App\Repositories\InstructorRepository;
use App\Shared\Handler\Result;
use App\Shared\Constants\StatusResponse;
use Illuminate\Http\JsonResponse;

class StatsService implements StatsServiceInterface
{
    protected StudentRepository $studentRepository;
    protected InstructorRepository $instructorRepository;

    public function __construct(
        StudentRepository $studentRepository,
        InstructorRepository $instructorRepository
    ) {
        $this->studentRepository = $studentRepository;
        $this->instructorRepository = $instructorRepository;
    }

    public function getStats()
    {
        $studentsCount = $this->studentRepository->count();
        $instructorsCount = $this->instructorRepository->count();

        $result = [
            'students'    => $studentsCount,
            'instructors' => $instructorsCount,
        ];


        return Result::success($result, 'Got All Stats Successfully', StatusResponse::HTTP_OK);
    }
}
