<?php

namespace App\Contracts;

use App\Models\User;

interface UserRepositoryInterface
{
    public function getAll();
    public function getById($id);
    public function getByEmail($email);
    public function create(array $data);
    public function activate($id);
    public function deactivate($id);
}
