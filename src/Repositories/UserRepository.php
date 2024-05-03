<?php

namespace App\Repositories;

use App\Model\User;
use App\Services\PasswordService;

class UserRepository
{

    public function create(array $data): User
    {
        $data['password'] = PasswordService::hashPassword($data['password']);
        (new User())->fill($data)->save();
        return $this->getByName($data['name']);
    }

    private function fillUserFromDb(array $dbData): User
    {
        return (new User())->fill($dbData)->setId($dbData['id']);
    }

    public function getByName(string $name): User
    {
        $dbData = (new User())->find(['name' => ucfirst($name)]);
        return $this->fillUserFromDb($dbData);
    }

    public function existsByName(string $param): bool
    {
        if ((new User())->find(['name' => $param])) {
            return true;
        } else {
            return false;
        }
    }

}