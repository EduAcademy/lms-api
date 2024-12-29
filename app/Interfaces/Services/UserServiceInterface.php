<?php

namespace App\Interfaces\Services;

interface UserServiceInterface {
    public function getUserById($id);
    public function getUserByEmail($email);
    public function registerUser(array $data);
    public function login(array $data);
    public function forgotPassword(array $data);
    public function resetPassword(array $data);
    public function validateToken(string $token);
    public function updateUser($id, array $data);
    public function deleteUser($id);
}
