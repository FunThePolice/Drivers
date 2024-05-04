<?php

namespace App\Repositories;

use App\Model\Profile;
use App\Model\User;

class ProfileRepository
{

    public function create(User $user): Profile
    {
        (new Profile())
            ->fill([
                'settings' => 'settings',
                'user_id' => $user->getId()
            ])
            ->save();

        return (new Profile())->find(['user_id' => $user->getId()]);
    }

}