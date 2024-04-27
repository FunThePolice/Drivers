<?php

namespace App\Repositories;

use App\Model\User;

class UserRepository
{

    private User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function create(array $data): User
    {
        $data['password'] = $this->hashPassword($data['password']);
        $this->user->fill($data)->save();
        return $this->getByName($data['name']);
    }

    public function fillUserFromDb(array $dbData): User
    {
        return $this->user->fill($dbData)->setId($dbData['id']);
    }

    public function getByName(string $name): User
    {
        $dbData = $this->user->find(['name' => ucfirst($name)]);
        return $this->fillUserFromDb($dbData);
    }

    public function existsByName(string $param): bool
    {
        if ($this->user->find(['name' => $param])) {
            return true;
        } else {
            return false;
        }
    }

    public function hashPassword(string $password): string
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    public function uuidGen()
    {
        $data = $data ?? random_bytes(16);
        assert(strlen($data) === 16);

        $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80);

        return vsprintf('%s%s', str_split(bin2hex($data), 4));
    }

}