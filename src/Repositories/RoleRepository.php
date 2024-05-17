<?php

namespace App\Repositories;

use App\Model\Role;

class RoleRepository
{

    public function create(array $data): Role
    {
        (new Role())->fill($data)->save();

        return (new Role())->find(['name' => $data['name']]);
    }

    public function getByKey(string $key, string $value): Role
    {
        return (new Role())->find([$key => $value]);
    }

    public function getById(int $id): Role
    {
        return (new Role())->find(['id' => $id]);
    }

    public function getAll(): array
    {
        return (new Role())->all();
    }
}