<?php

namespace App\Model;

class User extends BaseModel
{

    protected static string $table = 'users';

    protected array $fillable = ['name', 'email', 'password'];

    protected int $id;

    public string $name;

    public string $email;

    public string $password;

    public bool $permissionLevel = false;

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'email' => $this->email,
            'password' => $this->password,
            'permission_level' => $this->permissionLevel,
        ];
    }

    public function setId(int $id): User
    {
        $this->id = $id;
        return $this;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setName(string $name): void
    {
        $this->name = ucfirst($name);
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getPermissionLevel(): bool
    {
        return $this->permissionLevel;
    }

    public function setPermissionLevel(bool $permissionLevel)
    {
        $this->permissionLevel = $permissionLevel;
        return $this;
    }

}