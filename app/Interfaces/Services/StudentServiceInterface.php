<?php



namespace App\Interfaces\Services;


interface StudentServiceInterface
{
    public function getAllStudents();
    public function getStudentById($id);
    public function createStudent(array $data);
    public function updateStudent($id, array $data);
    public function getStudentsByDepartment($departmentId);
    public function count(): int;
    public function getStudentsByGroup($groupId);
    public function findByUserId($userId);
    public function getStudentsBySubGroupId($subgroupId);
    public function uploadAndImportStudents($file);
    public function deleteStudent($id);
}
