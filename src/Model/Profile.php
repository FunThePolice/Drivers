<?php

namespace App\Model;

class Profile extends BaseModel
{

    protected static string $table = 'profiles';

    protected array $fillable = ['settings' ,'user_id'];

    public int $id;

    public int $userId;

    public string $settings = 'settings';

    public function toArray(): array
    {
        return [
            'settings' => $this->settings,
            'user_id' => $this->userId,
        ];
    }

    public function setSettings(string $settings = 'settings'): void
    {
        $this->settings = $settings;
    }

    public function getSettings(): string
    {
        return $this->settings;
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