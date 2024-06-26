<?php

namespace App\Repositories;

use App\Helpers\Dumper;
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

    public function update(Profile $profile): Profile
    {
        Dumper::dd($profile->toArray());
        $profile->update(['id' => $profile->getId()]);

        return (new Profile())->find(['id' => $profile->getId()]);
    }

    public function getByKey(string $key, $value): Profile
    {
        return (new Profile())->find([$key => $value]);
    }

    public function getById(int $id): Profile
    {
        return (new Profile())->find(['id' => $id]);
    }

    public function getByUserId(int $userId): Profile
    {
        return (new Profile())->find(['user_id' => $userId]);
    }

    public function getAll(): array
    {
        return (new Profile())->all();
    }

}