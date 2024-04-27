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
        $profile = $this->profileRepository->create($user->getId());
        $viewUserId = $this->userRepository->uuidGen();
        $user->setId($viewUserId);
        $profile->setUser_id($viewUserId);
        return compact('user','profile');
    }

    public function verifyUser(array $data): bool
    {
        if ($this->checkIfUserExist($data)) {
            $user = $this->userRepository->getByName($data['name']);
        }

        if (password_verify($data['password'], $user->getPassword())) {
            return true;
        } else {
            return false;
        }

    }

    public function checkIfUserExist(array $data): bool
    {
       return $this->userRepository->existsByName($data['name']);
    }

}