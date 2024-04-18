<?php

namespace App\Helpers;

class MySessionHelper
{
    public function getUserStatus(array $session): bool
    {
        return isset($session['is_authorized']) && $session['is_authorized'] === true;
    }

    public function setUserStatus(bool $status): void
    {
        $_SESSION['is_authorized'] = $status;
    }

}