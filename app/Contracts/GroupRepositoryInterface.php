<?php

namespace App\Contracts;

interface GroupRepositoryInterface
{
    //

    public function getAll();
    public function getById($id);
    public function create(array $data);
}
