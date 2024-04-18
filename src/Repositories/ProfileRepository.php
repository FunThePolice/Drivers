<?php

namespace App\Repositories;

use App\Builder\Builder;
use App\Model\Profile;

class ProfileRepository
{
    private Builder $builder;

    public function __construct(Builder $builder)
    {
        $this->builder = $builder;
    }

    public function create(array $data): bool|array|null
    {
        $profile = (new Profile())->fill(['userId' => $data['id']]);
        $this->builder->create($profile->getTable(), $profile->toArray());
        return $this->builder->get('profiles','userId', $data['id']);
    }
}