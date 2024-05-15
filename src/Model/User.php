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

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'email' => $this->email,
            'password' => $this->password,
        ];
    }

    public function roles(): ?array
    {
        return $this->getBuilder()->getMany($this, Role::class, 'role_user', 'role_id', 'user_id');
    }

    public function setRole(Role $role): void
    {
        $this->getBuilder()->setRelated($this, $role->getId(), 'role_user', 'role_id', 'user_id');
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
        $this->name = $name;
    }

    public function getName(): string
    {
        return ucfirst($this->name);
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

}