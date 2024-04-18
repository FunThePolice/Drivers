<?php

namespace App\Model;

class Profile extends BaseModel
{
    protected string $table = 'profiles';
    protected array $fillable = ['settings', 'userId'];
    public string $userId;
    public string $settings = 'settings';

    public function toArray(): array
    {
        return [
            'settings' => $this->settings,
            'userId' => $this->userId,
        ];
    }
    public function setSettings(string $settings): void
    {
        $this->settings = $settings;
    }

    public function setUserId(string $userId): void
    {
        $this->userId = $userId;
    }

}