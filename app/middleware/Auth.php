<?php

declare(strict_types=1);

use Delight\Auth;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../config');
$dotenv->load();
class AuthMiddleware
{
    private PDO $db;
    private Auth\Auth $auth;

    public function __construct()
    {
        $this->db = new PDO('mysql:dbname=' . $_ENV['DB_NAME'] . ';host=' . $_ENV['DB_HOST'] . ';charset=utf8mb4', $_ENV['DB_USER'], $_ENV['DB_PASSWORD']);
        $this->auth = new Auth\Auth($this->db);
    }

    public function check(): bool
    {
        return $this->auth->isLoggedIn();
    }
}