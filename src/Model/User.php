<?php

namespace App\Model;

class User extends BaseModel
{

    protected static string $table = 'users';

    protected array $fillable = ['name', 'email', 'password'];

    protected string|int $id;

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

    public function setId(int|string $id)
    {
        $this->id = $id;
        return $this;
    }

    public function getId(): string|int
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

}