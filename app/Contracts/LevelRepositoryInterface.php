<?php

namespace App\Contracts;

interface LevelRepositoryInterface
{
    //
    public function getLevels($instructorId, $departmentId);
}
