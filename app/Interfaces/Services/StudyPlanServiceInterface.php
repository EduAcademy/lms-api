<?php

namespace App\Interfaces\Services;

interface StudyPlanServiceInterface
{
    public function getAllStudyPlans();
    public function getStudyPlanById($id);
    public function createStudyPlan(array $data);
    public function updateStudyPlan($id, array $data);
    public function deleteStudyPlan($id);
}
