<?php

namespace App\Model;

class Profile extends BaseModel
{

    protected static string $table = 'profiles';

    protected array $fillable = ['first_name', 'last_name', 'middle_name', 'user_id'];

    public int $id;

    public int $userId;

    public string $firstName;

    public string $lastName;

    public string $middleName;

    public function toArray(): array
    {
        return [
            'first_name' => $this->firstName,
            'last_name' => $this->lastName,
            'middle_name' => $this->middleName,
            'user_id' => $this->userId
        ];
    }

    public function setFirstName(string $firstName): void
    {
        $this->firstName = $firstName;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function setLastName(string $lastName): void
    {
        $this->lastName = $lastName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function setMiddleName(string $middleName): void
    {
        $this->middleName = $middleName;
    }

    public function getMiddleName(): string
    {
        return $this->middleName;
    }

    public function setUserId(int $userId)
    {
        $this->userId = $userId;
        return $this;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function setId(int $id): Profile
    {
        $this->id = $id;
        return $this;
    }

    public function getId(): int
    {
        return $this->id;
    }

}