<?php

namespace App\Services;

use App\Helpers\Dumper;
use App\Model\Role;
use App\Model\User;
use App\Repositories\ProfileRepository;
use App\Repositories\RoleRepository;
use App\Repositories\UserRepository;

class UserService
{

    private UserRepository $userRepository;

    private ProfileRepository $profileRepository;

    private RoleRepository $roleRepository;

    public function __construct(
        UserRepository $userRepository,
        ProfileRepository $profileRepository,
        RoleRepository $roleRepository)

    {
        $this->userRepository = $userRepository;
        $this->profileRepository = $profileRepository;
        $this->roleRepository = $roleRepository;
    }

    public function createUser(array $data): array
    {
        $user = $this->userRepository->create($data);
        $profile = $this->profileRepository->create($user);

        return compact('user','profile');
    }

    public function getUserByKey(string $key, string $value): User
    {
        return $this->userRepository->getByKey($key, $value);
    }

    public function getUserById(string $id): User
    {
        return $this->userRepository->getById($id);
    }

    public function verifyUser(array $data): bool
    {
        if ($this->isUserNameExist($data)) {
            $user = $this->userRepository->getByKey('name', $data['name']);
            Dumper::dd($user);
        }

        /** @var User $user */
        return PasswordService::verifyPassword($data['password'], $user->getPassword());
    }

    public function isUserNameExist(array $data): bool
    {
       return $this->userRepository->existsByName($data['name']);
    }

    public function getAll(): array
    {
        return $this->userRepository->getAll();
    }

    public function setRole(Role $role): void
    {
        $this->userRepository->pair($role);
    }

    public function getUserRole(int $userId): array|null
    {
        $pair = $this->userRepository->getById($userId)->roles();

        if (is_null($pair)) {
            return null;
        }

        return $pair;
    }

}