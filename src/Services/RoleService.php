<?php

namespace App\Services;

use App\Model\Role;
use App\Repositories\RoleRepository;

class RoleService
{

    private RoleRepository $roleRepository;

    public function __construct(RoleRepository $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }

    public function createRole(array $data): Role
    {
        return $this->roleRepository->create($data);
    }

    public function getAll(): array
    {
        return $this->roleRepository->getAll();
    }

    public function getRoleByKey(string $key, $value): Role
    {
        return $this->roleRepository->getByKey($key, $value);
    }

    public function getRoleById(string $id): Role
    {
        return $this->roleRepository->getById($id);
    }

}