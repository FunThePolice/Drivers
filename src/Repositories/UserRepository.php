<?php

namespace App\Repositories;

use App\Model\BaseModel;
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

    public function getByKey(string $key , $value): User|bool
    {
        return (new User())->find([$key => $value]);
    }

    public function existsByName(string $param): bool
    {
        return (bool) (new User())->find(['name' => $param]);
    }

}