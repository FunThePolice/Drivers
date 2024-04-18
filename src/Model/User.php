<?php

namespace App\Model;


class User extends BaseModel
{
    protected string $table = 'users';

    protected array $fillable = ['name', 'email', 'password'];
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
    public function setId(string $id): void
    {
        $this->id = $id;
    }

    public function getId(): string
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
        $this->password = password_hash($password, PASSWORD_DEFAULT);
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    }