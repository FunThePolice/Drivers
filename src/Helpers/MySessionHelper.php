<?php

namespace App\Helpers;

class MySessionHelper
{

    const USER_STATE_KEY = 'is_authorized';
    const ADMIN_STATE_KEY = 'is_admin';

    public function getUserStatus(array $session): bool
    {
        return isset($session[static::USER_STATE_KEY]) && $session[static::USER_STATE_KEY] === true;
    }

    public function setUserState(array &$session, bool $state): void
    {
        $this->setSessionKey($session, static::USER_STATE_KEY, $state);
    }

    public function setAdminState(array &$session, bool $state): void
    {
        $this->setSessionKey($session, static::ADMIN_STATE_KEY, $state);
    }

    public function getAdminState(array $session): bool
    {
        return isset($session[static::ADMIN_STATE_KEY]) && $session[static::ADMIN_STATE_KEY] === true;
    }

    public function setSessionKey(array &$session, string $key, $value): void
    {
        $session[$key] = $value;
    }

}