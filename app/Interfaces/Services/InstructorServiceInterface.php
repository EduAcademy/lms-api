<?php

namespace App\Interfaces\Services;

use App\Models\Instructor;

interface InstructorServiceInterface
{
    public function getAll();
    public function findById($id);
    public function createInstructor(array $data);
    public function updateInstructor(Instructor $instructor, array $data);
    public function deleteInstructor(Instructor $instructor);
}
