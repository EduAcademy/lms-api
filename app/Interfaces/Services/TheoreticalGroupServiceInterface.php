<?php

namespace App\Interfaces\Services;

interface TheoreticalGroupServiceInterface
{
    //
    public function getAllTheoGroups();
    public function getTheoGroupById($id);
    public function createTheoGroup(array $data);
    public function updateLabGroup($id, array $data);
    public function deleteLabGroup($id);
}
