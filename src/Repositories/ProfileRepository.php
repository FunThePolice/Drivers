<?php

namespace App\Repositories;

use App\Model\Profile;

class ProfileRepository
{

    private Profile $profile;

    public function __construct(Profile $profile)
    {
        $this->profile = $profile;
    }

    public function create(int $userId): Profile
    {
        $this->profile
            ->fill(['settings' => 'settings'])
            ->setUser_id($userId)
            ->save();
        return $this->profile;
    }

}