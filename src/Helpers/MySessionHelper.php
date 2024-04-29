<?php

namespace App\Helpers;

class MySessionHelper
{

    const USER_STATE_KEY = 'is_authorized';

    public function getUserStatus(array $session): bool
    {
        return isset($session[static::USER_STATE_KEY]) && $session[static::USER_STATE_KEY] === true;
    }

    public function setUserState(array $session, bool $state): array
    {
        return $this->setSessionKey($session, static::USER_STATE_KEY, $state);
    }

    public function setSessionKey($session, $key, $value): array
    {
        $session[$key] = $value;
        return $session ?? [];
    }

}