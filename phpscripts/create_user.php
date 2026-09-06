<?php

declare(strict_types=1);


require __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../config');
$dotenv->load();

use Delight\Auth;


$db  = new \PDO('mysql:dbname=' . $_ENV['DB_NAME'] . ';host=' . $_ENV['DB_HOST'] . ';charset=utf8mb4', $_ENV['DB_USER'], $_ENV['DB_PASSWORD']);
$auth = new Auth\Auth($db);
function create_user(string $email, string $password, string $name) 
{
    try {
        global $auth;
        $user = $auth->register($email, $password, $name);
        $auth->admin()->addRoleForUserById($user, \Delight\Auth\Role::ADMIN); //admin role
    }

    catch (\Delight\Auth\InvalidEmailException $e) {
        echo 'Invalid email address';
    }
    catch (\Delight\Auth\InvalidPasswordException $e) {
        echo 'Invalid password';
    }
    catch (\Delight\Auth\UserAlreadyExistsException $e) {
        echo 'User already exists';
    }
    catch (\Delight\Auth\TooManyRequestsException $e) {
        echo 'Too many requests';
    }
}

create_user($argv[1], $argv[2], $argv[3]);