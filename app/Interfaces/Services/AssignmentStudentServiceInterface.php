<?php

namespace App\Interfaces\Services;

interface AssignmentStudentServiceInterface
{
    public function getAllAssignmentStudents();
    public function getAssignmentStudentById($id);
    public function createAssignmentStudent(array $data);
    public function updateAssignmentStudent($id, array $data);
    public function deleteAssignmentStudent($id);
    public function getByStudentId($studentId);
}
