<?php

declare(strict_types=1);


require __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../generated-conf/config.php';

function create_user(string $email, string $password, string $role, string $name) 
{
    $user = new Users();
    $user->setEmail($email);
    $user->setPasswordHash(password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]));
    $user->setRole($role);
    $user->setName($name);
    $user->save();
}

create_user($argv[1], $argv[2], $argv[3], $argv[4]);