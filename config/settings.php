<?php

declare(strict_types=1);

namespace App\Config;

final class Settings
{
    public const APP_URL = 'http://localhost/stthomas-events/';
    public const REMEMBER_ME_DURATION = 60 * 60 * 24 * 7; // 7 days
}

final class MyRole
{
    public const STAFF = \Delight\Auth\Role::EMPLOYEE;
}