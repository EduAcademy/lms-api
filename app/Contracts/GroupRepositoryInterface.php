<?php

namespace App\Contracts;

interface GroupRepositoryInterface
{
    //

    public function getAll();
    public function getById($id);
    public function getByName($name);
    public function create(array $data);
}
