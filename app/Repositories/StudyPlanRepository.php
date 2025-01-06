<?php

namespace App\Repositories;

use App\Contracts\StudyPlanRepositoryInterface;
use App\Models\StudyPlan;

class StudyPlanRepository Implements StudyPlanRepositoryInterface
{

    public function getAll()
    {
        $studyplans = StudyPlan::all();
        return $studyplans;
    }

    public function getById($id)
    {
        $studyplan = StudyPlan::find($id);
        return $studyplan;
    }

    public function create(array $data)
    {
        return StudyPlan::create($data); // Bulk insert into the database
    }

}
