<?php

declare(strict_types=1);

namespace App\Config;

final class Settings
{
    public const APP_URL = 'http://localhost/stthomas-events/';
    public const APP_VERSION = '1.0';
    public const STAGE = 1; //0=dev 1=prod
    public const HOLD_DURATION = 60 * 5; // 5 minutes
    public const EMAIL_CONFIRMATION_DURATION = 60 * 5; // 5 minutes
    public const REMEMBER_ME_DURATION = 60 * 60 * 24 * 7; // 7 days
    public const STAFF_TABLE_MAX_ROWS = 10;
    public const SUPPORT_EMAIL = 'support@stthomas-events.com';
}

final class MyRole
{
    public const STAFF = \Delight\Auth\Role::EMPLOYEE;
}