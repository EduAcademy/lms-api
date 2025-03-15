<?php

namespace App\Services;

use App\Interfaces\Services\StatsServiceInterface;
use App\Repositories\StudentRepository;
use App\Repositories\InstructorRepository;

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

    public function getStats(): array
    {
        $studentsCount = $this->studentRepository->count();
        $instructorsCount = $this->instructorRepository->count();

        return [
            'students'    => $studentsCount,
            'instructors' => $instructorsCount,
        ];
    }
}
