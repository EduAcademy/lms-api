<?php

namespace App\Interfaces\Services;

use App\Models\Instructor;

interface InstructorServiceInterface
{
    public function getAllInstructors();
    public function getInstructorById($id);
    public function createInstructor(array $data);
    public function updateInstructor(Instructor $instructor, array $data);
    public function deleteInstructor(Instructor $instructor);
}
