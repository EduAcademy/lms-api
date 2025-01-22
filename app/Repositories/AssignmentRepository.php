<?php

namespace App\Repositories;

use App\Contracts\AssignmentRepositoryInterface;
use App\Models\Assignment;

class AssignmentRepository implements AssignmentRepositoryInterface
{
    public function getAll()
    {
        $result = Assignment::all();

        return $result;
    }

    public function getById()
    {

    }

    public function create()
    {

    }

    public function getByInstructorId($instructorId)
    {

    }

    public function getBySpCinstId($spCInstId)
    {

    }

    public function getBySpCinstSubGroId($spCInstSubGroId)
    {

    }
}
