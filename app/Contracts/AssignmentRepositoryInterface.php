<?php

namespace App\Contracts;

interface AssignmentRepositoryInterface
{
    //
    public function getAll();
    public function getById();
    public function create();
    public function getByInstructorId($instructorId);
    public function getBySpCinstId($spCInstId);
    public function getBySpCinstSubGroId($spCInstSubGroId);
}
