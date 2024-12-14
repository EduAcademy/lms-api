<?php

namespace App\Services;

use App\Contracts\InstructorRepositoryInterface;
use App\Interfaces\Services\InstructorServiceInterface;
use App\Models\Instructor;

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
    public function createInstructor(array $data) {}
    public function updateInstructor($id, array $data) {}
    public function deleteInstructor($id) {}
}
