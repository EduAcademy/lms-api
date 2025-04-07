<?php

namespace App\Repositories;

use App\Models\AssignmentStudent;
use App\Contracts\AssignmentStudentRepositoryInterface;

class AssignmentStudentRepository implements AssignmentStudentRepositoryInterface
{
    public function getAll()
    {
        return AssignmentStudent::all();
    }

    public function getById($id)
    {
        return AssignmentStudent::find($id);
    }

    public function create(array $data)
    {
        return AssignmentStudent::create($data);
    }

    public function update($id, array $data)
    {
        $assignmentStudent = AssignmentStudent::find($id);
        if ($assignmentStudent) {
            $assignmentStudent->update($data);
            return $assignmentStudent;
        }
        return null;
    }

    public function delete($id)
    {
        $assignmentStudent = AssignmentStudent::find($id);
        if ($assignmentStudent) {
            $assignmentStudent->delete();
            return true;
        }
        return false;
    }

    public function getByStudentId($studentId)
    {
        return AssignmentStudent::where('student_id', $studentId)->get();
    }
}
