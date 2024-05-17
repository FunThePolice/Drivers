<?php

namespace App\Repositories;

use App\Model\BaseModel;
use App\Model\Role;
use App\Model\User;
use App\Services\PasswordService;

class UserRepository
{

    public function create(array $data): User
    {
        $data['password'] = PasswordService::hashPassword($data['password']);
        (new User())->fill($data)->save();

        return $this->getByKey('name', $data['name']);
    }

    public function getByKey(string $key, string $value): User|bool
    {
        return (new User())->find([$key => $value]);
    }

    public function getById(int $id): User|bool
    {
        return (new User())->find(['id' => $id]);
    }

    public function existsByName(string $param): bool
    {
        return (bool) (new User())->find(['name' => $param]);
    }

    public function getAll(): array
    {
        return (new User())->all();
    }

}