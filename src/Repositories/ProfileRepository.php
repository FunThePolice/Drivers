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
        var_dump($data);
        var_dump($profile->toArray());
        var_dump((new Profile())->fill($data));
        (new Profile())->fill($data)->update($profile->toArray());

        return (new Profile())->find($data);
    }

    public function getByKey(string $key, $value): Profile
    {
        return (new Profile())->find([$key => $value]);
    }

}