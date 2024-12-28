<?php

namespace App\Contracts;

use App\Models\User;

interface UserRepositoryInterface
{
    public function getAll();
    public function findById($id);
    public function findByEmail($email);
    public function createUser(array $data);
    public function updateUser(User $user, array $data);
}
