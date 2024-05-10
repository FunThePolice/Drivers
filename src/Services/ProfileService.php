<?php

namespace App\Services;

use App\Model\Profile;
use App\Repositories\ProfileRepository;

class ProfileService
{

    private ProfileRepository $profileRepository;

    public function __construct(ProfileRepository $profileRepository)
    {
        $this->profileRepository = $profileRepository;
    }

    public function updateInfo(array $data, int $value): Profile
    {
        return $this->profileRepository->update($data, $this->profileRepository->getByUserId($value));
    }

    public function getAll(): array
    {
        return $this->profileRepository->getAll();
    }

}