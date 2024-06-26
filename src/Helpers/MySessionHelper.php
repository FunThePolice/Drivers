<?php

namespace App\Helpers;

class MySessionHelper
{

    const USER_STATE_KEY = 'is_authorized';

    const ADMIN_ROLE = 'Admin';

    public function isUserAuth(array $session): bool
    {
        return isset($session[static::USER_STATE_KEY]) && $session[static::USER_STATE_KEY] === true;
    }

    public function setUserState(array &$session, bool $state): void
    {
        $this->setSessionKey($session, static::USER_STATE_KEY, $state);
    }

    public function setSessionKey(array &$session, string $key, $value): void
    {
        $session[$key] = $value;
    }

    public function isAdmin(array $session): bool
    {
        foreach ($session['user']->roles as $role) {
            if ($role->getName() === static::ADMIN_ROLE) {
                return true;
            }
        }
        return false;
    }


}