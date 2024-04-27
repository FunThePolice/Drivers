<?php

namespace App\Model;

class Profile extends BaseModel
{

    protected static string $table = 'profiles';

    protected array $fillable = ['settings'];

    public int|string $user_id;

    public string $settings = 'settings';

    public function toArray(): array
    {
        return [
            'settings' => $this->settings,
            'user_id' => $this->user_id,
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

    public function setUser_id(int|string $userId)
    {
        $this->user_id = $userId;
        return $this;
    }

    public function getUser_Id(): int
    {
        return $this->user_id;
    }

}