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

    public function update(array $data, Profile $profile): Profile
    {
        (new Profile())->fill($data)->update($profile->toArray());

        return (new Profile())->find($data);
    }

    public function getByKey(string $key, $value): Profile
    {
        return (new Profile())->find([$key => $value]);
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