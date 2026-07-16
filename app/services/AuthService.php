<?php

declare(strict_types=1);


use Respect\Validation\Validator as v;
use Delight\Auth;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../config');
$dotenv->load();
class AuthService
{
    private PDO $db;
    private Auth\Auth $auth;

    public function __construct()
    {
        $this->db = new PDO('mysql:dbname=' . $_ENV['DB_NAME'] . ';host=' . $_ENV['DB_HOST'] . ';charset=utf8mb4', $_ENV['DB_USER'], $_ENV['DB_PASSWORD']);
        $this->auth = new Auth\Auth($this->db);
    }
    public function authenticate(string $email, string $password): string|true
    {
        try {
            $this->auth->login($email, $password);
            return true;
        } catch (Auth\InvalidEmailException | Auth\InvalidPasswordException) {
            throw new Error('Incorrect email address or password.');
        } catch (Auth\EmailNotVerifiedException) {
            throw new Error('Email address is not verified.');
        } catch (Auth\TooManyRequestsException) {
            throw new Error('Too many requests. Please try again later.');
        }
    }
}