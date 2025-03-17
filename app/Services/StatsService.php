<?php
// filepath: d:\LMS\lms-api\app\Services\StatsService.php

namespace App\Services;

use App\Interfaces\Services\StatsServiceInterface;
use App\Repositories\StudentRepository;
use App\Repositories\InstructorRepository;
use App\Repositories\UserRepository;
use App\Shared\Handler\Result;
use App\Shared\Constants\StatusResponse;
use Illuminate\Http\JsonResponse;

class StatsService implements StatsServiceInterface
{
    protected StudentRepository $studentRepository;
    protected InstructorRepository $instructorRepository;
    protected UserRepository $userRepository;

    public function __construct(
        StudentRepository $studentRepository,
        InstructorRepository $instructorRepository,
        UserRepository $userRepository
    ) {
        $this->studentRepository = $studentRepository;
        $this->instructorRepository = $instructorRepository;
        $this->userRepository = $userRepository;
    }

    public function getStats(): JsonResponse
    {
        $studentsCount    = $this->studentRepository->count();
        $instructorsCount = $this->instructorRepository->count();

        // Use the new repository methods to get active users counts
        $activeNow       = $this->userRepository->activeNowCount();
        $activeLastHour  = $this->userRepository->activeLastHourCount();

        $result = [
            'students'                => $studentsCount,
            'instructors'             => $instructorsCount,
            'active_now'              => $activeNow,
            'active_since_last_hour'  => $activeLastHour,
        ];

        return Result::success($result, 'Got All Stats Successfully', StatusResponse::HTTP_OK);
    }
}
