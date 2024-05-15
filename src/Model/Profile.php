<?php

namespace App\Model;

use App\Helpers\Dumper;

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
            $key =\lcfirst(\str_replace('_', '', \ucwords($value, '_')));
            if (isset($this->{$key})) {
                $result[$value] = $this->{$key};
            }
        }
        return $result;
    }

    public function setFirstName(string $firstName): void
    {
        $this->firstName = lcfirst($firstName);
    }

    public function getFirstName(): string
    {
        return ucfirst($this->firstName);
    }

    public function setLastName(string $lastName): void
    {
        $this->lastName = lcfirst($lastName);
    }

    public function getLastName(): string
    {
        return ucfirst($this->lastName);
    }

    public function setMiddleName(string $middleName): void
    {
        $this->middleName = lcfirst($middleName);
    }

    public function getMiddleName(): string
    {
        return ucfirst($this->middleName);
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