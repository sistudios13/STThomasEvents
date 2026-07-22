<?php

declare(strict_types=1);

namespace App\Services;

use Respect\Validation\Validator as v;
use Delight\Auth;
use Dotenv;
use App\Config\Settings;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../config');
$dotenv->load();
class AuthService
{
    private \PDO $db;
    private Auth\Auth $auth;

    public function __construct()
    {
        $this->db = new \PDO('mysql:dbname=' . $_ENV['DB_NAME'] . ';host=' . $_ENV['DB_HOST'] . ';charset=utf8mb4', $_ENV['DB_USER'], $_ENV['DB_PASSWORD']);
        $this->auth = new Auth\Auth($this->db);
    }
    public function authenticate(string $email, string $password, bool $remember): string|true
    {   
        $duration = $remember ? (int) Settings::REMEMBER_ME_DURATION : null;

        try {
            $this->auth->login($email, $password, $duration);
            return true;
        } catch (Auth\InvalidEmailException | Auth\InvalidPasswordException) {
            throw new \Error('Incorrect email address or password.');
        } catch (Auth\EmailNotVerifiedException) {
            throw new \Error('Email address is not verified.');
        } catch (Auth\TooManyRequestsException) {
            throw new \Error('Too many requests. Please try again later.');
        }
    }

    public function logout(): void
    {
        $this->auth->logOut();
        $this->auth->destroySession();
    }
}