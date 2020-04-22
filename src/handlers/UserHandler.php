<?php

namespace src\handlers;

use src\models\User;

class UserHandler extends User
{
    public static function nameToSlug(string $name)
    {
        $userSlug = str_replace(' ', '', $name);
        $userSlug = strtolower($userSlug);
        return $userSlug;
    }
}
