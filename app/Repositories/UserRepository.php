<?php

namespace App\Repositories;

use App\Contracts\UserRepositoryInterface;
use App\Models\User;

class UserRepository implements UserRepositoryInterface
{

    public function getAll()
    {
        return User::all();
    }

    public function findById($id)
    {
        return User::find($id);
    }

    public function findByEmail($email)
    {
        return User::where('email', $email)->first();
    }

    public function createUser(array $data)
    {
        return User::create($data);
    }

    public function updateUser(User $user, array $data)
    {
        return $user->update($data);
    }
}
