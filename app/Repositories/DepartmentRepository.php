<?php
namespace App\Repositories;


use App\Models\Department;
use App\Contracts\DepartmentRepositoryInterface;


class DepartmentRepository implements DepartmentRepositoryInterface{
    
    public function findById($id)
    {
        return Department::find($id);
    }

    public function findByShortName($shortName)
    {
        return Department::where('short_name', $shortName)->first();
    }

    public function create(array $data)
    {
        return Department::create($data);
    }

    public function update(Department $department, array $data)
    {
        return $department->update($data);
    }
}
