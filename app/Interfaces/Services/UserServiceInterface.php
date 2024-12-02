<?php

namespace App\Interfaces\Services;

interface UserServiceInterface {
    public function getUserById($id);
    public function getUserByEmail($email);
    public function registerUser(array $data);
    public function login(array $data);
}