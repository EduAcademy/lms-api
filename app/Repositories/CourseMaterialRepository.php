<?php

namespace App\Repositories;

use App\Contracts\CourseMaterialRepositoryInterface;
use App\Models\CourseMaterial;

class CourseMaterialRepository implements CourseMaterialRepositoryInterface
{
    public function getAll()
    {
        $result = CourseMaterial::all();
        return $result;
    }

    public function getById($id)
    {
        $result = CourseMaterial::find($id);
        return $result;
    }

    public function getByInstructorId($instructorId)
    {
        $result = CourseMaterial::with('instructor')->get();
        return $result;
    }

    public function getByCourseId($courseId)
    {
        $result = CourseMaterial::with('course')->get();
        return $result;
    }

    public function create(array $data)
    {
        $result = CourseMaterial::create($data);
        return $result;
    }

}
