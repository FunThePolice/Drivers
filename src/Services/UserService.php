<?php

namespace App\Services;

use App\Helpers\MyUuidHelper;
use App\Model\User;
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

    public function verifyUser(array $data): bool
    {
        if ($this->isUserNameExist($data)) {
            $user = $this->userRepository->getByKey('name', $data['name']);
        }

        /** @var User $user */
        return PasswordService::verifyPassword($data['password'], $user->getPassword());
    }

    public function isUserNameExist(array $data): bool
    {
       return $this->userRepository->existsByName($data['name']);
    }

}