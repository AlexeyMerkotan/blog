<?php

namespace common\models;

class Role
{
    const ROLE_USER = 'user';
    const ROLE_ADMIN = 'admin';

    /**
     * @return string[]
     */
    public function getRoles()
    {
        return [self::ROLE_USER, self::ROLE_ADMIN];
    }
}
