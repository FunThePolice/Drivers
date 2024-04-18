<?php

namespace App\Services;

use App\Repositories\ProfileRepository;
use App\Repositories\UserRepository;

class UserService
{

    private UserRepository $userRepository;
    private ProfileRepository $profileRepository;

    public function __construct(UserRepository $userRepository, ProfileRepository $profileRepository)
    {
        $this->userRepository = $userRepository;
        $this->profileRepository = $profileRepository;
    }
    public function createUser(array $data): array
    {
        $user = $this->userRepository->create($data);
        $profile = $this->profileRepository->create($user);
        return compact('user','profile');
    }

    public function checkIfExist(string $name): bool
    {
        return $this->userRepository->existsByName($name);
    }

    public function verifyName(array $data): bool
    {
        return $this->checkIfExist($data['name']);
    }

    public function verifyPassword(array $data, array $password): bool
    {
        return password_verify($data['password'], $password['Password']);
    }

    public function verifyUser(array $data): bool
    {
        if ($this->verifyName($data)) {
            $user = $this->userRepository->getByName($data['name']);
        }
        return $this->verifyPassword($data, $user);
    }

}