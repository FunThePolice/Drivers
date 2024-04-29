<?php

namespace App\Repositories;

use App\Model\Profile;

class ProfileRepository
{

    public function create(int $userId): Profile
    {
        (new Profile())
            ->fill(['settings' => 'settings'])
            ->setUserId($userId)
            ->save();
        return (new Profile());
    }

}