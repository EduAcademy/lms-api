<?php

namespace App\Services;

use App\Contracts\UserRepositoryInterface;
use App\Interfaces\Services\UserServiceInterface;
use App\Shared\Handler\Result;
use Illuminate\Support\Facades\Hash;

class UserService implements UserServiceInterface
{
    protected $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getUserById($id) {
        return $this->userRepository->findById($id);
    }

    public function getUserByEmail($email) {
        return $this->userRepository->findByEmail($email);
    }

    public function registerUser(array $data)
    {
        
        
        $data['password'] = Hash::make($data['password']); // Ensure password is hashed
        return $this->userRepository->createUser($data);
    }

    public function login(array $data)
    {
        if (!auth()->attempt($data)) {
            return Result::error('Invalid credentials', 401);
        }

        $user = auth()->user();
        $token = $user->createToken("auth_token")->plainTextToken;

        return Result::successwithtoken($user, $token, 'Logged in successfully', 200);
    }
}
