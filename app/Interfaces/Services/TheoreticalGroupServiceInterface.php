<?php

namespace App\Interfaces\Services;

interface TheoreticalGroupServiceInterface
{
    //
    public function getAllTheoGroups();
    public function getTheoGroupById($id);
    public function createTheoGroup(array $data);
}
