<?php

namespace App\Repositories;

use App\Builder\Builder;
use App\Model\User;

class UserRepository
{
    private Builder $builder;

    public function __construct(Builder $builder)
    {
        $this->builder = $builder;

    }
    public function create(array $data): array|null
    {
        $user = (new User())->fill($data);
        $id = $this->generateId($user);
        $this->builder->create($user->getTable(), array_merge(['id' => $id], $user->toArray()));
        return $this->builder->getById($user->getTable(),$id);
    }

    public function getByName(string $name): array|bool
    {
        return $this->builder->get('users', 'name', $name);
    }
    public function existsByName(string $param): bool
    {
        return $this->builder->exist('users','name',$param);
    }

    public function generateId(User $user): string
    {
        $id = $this->uuidGen();

        while ($this->builder->exist($user->getTable(),'id',$id)){
            $id = $this->uuidGen();
            break;
        }

        return $id;
    }

    public function uuidGen()
    {
        $data = $data ?? random_bytes(16);
        assert(strlen($data) == 16);

        $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80);

        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
    }

    public function getBuilder(): Builder
    {
        return $this->builder;
    }
}