<?php

namespace App\Services;

use App\Helpers\Dumper;
use App\Model\Profile;
use App\Repositories\ProfileRepository;

class ProfileService
{

    private ProfileRepository $profileRepository;

    public function __construct(ProfileRepository $profileRepository)
    {
        $this->profileRepository = $profileRepository;
    }

    public function updateInfo(Profile $profile): Profile
    {
        return $this->profileRepository->update($profile);
    }

    public function getAll(): array
    {
        return $this->profileRepository->getAll();
    }

    public function getById(int $id): Profile
    {
        return $this->profileRepository->getById($id);
    }

    public function getByUserId(int $userId): Profile
    {
        return $this->profileRepository->getByUserId($userId);
    }

}