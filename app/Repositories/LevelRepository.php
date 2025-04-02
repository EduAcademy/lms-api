<?php

namespace App\Repositories;

use App\Contracts\LevelRepositoryInterface;
use App\Models\Level;

class LevelRepository implements LevelRepositoryInterface
{


    public function getLevels($instructorId, $departmentId)
    {
        return Level::whereHas('sp_courses', fn($q) =>
            $q->where('department_id', $departmentId)
              ->whereHas('instructors', fn($q) =>
                  $q->where('instructor_id', $instructorId)
              )
        ->get(['id', 'name']));
    }
}
