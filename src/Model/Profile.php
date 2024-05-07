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
        foreach ($this->fillable as $value) {
            $value =\lcfirst(\str_replace('_', '', \ucwords($value, '_')));
            if (isset($this->{$value})) {
                $result[$value] = $this->{$value};
            }
        }
        return $result;
    }

    public function setFirstName(string $firstName): void
    {
        $this->firstName = ucfirst($firstName);
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function setLastName(string $lastName): void
    {
        $this->lastName = ucfirst($lastName);
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function setMiddleName(string $middleName): void
    {
        $this->middleName = ucfirst($middleName);
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