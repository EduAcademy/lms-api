<?php

namespace App\Contracts;

interface TheoreticalGroupRepositoryInterface
{
    //

    public function getAll();
    public function getById($id);
    public function create(array $data);
}
