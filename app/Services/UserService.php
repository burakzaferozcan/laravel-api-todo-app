<?php

namespace App\Services;


use App\Repositories\UserRepository;

class UserService
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function register($data)
    {
        return $this->userRepository->register($data);
    }

    public function login($data)
    {
        return $this->userRepository->login($data);
    }

    public function user($data)
    {
        return $this->userRepository->user();
    }

    public function updateUserImage($userId, $data)
    {
        return $this->userRepository->updateUserImage($userId, $data);
    }

}
