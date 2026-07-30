<?php

declare(strict_types=1);

namespace App\Staff\Services;

use Respect\Validation\Validator as v;
use Delight\Auth;
use Dotenv;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../../config');
$dotenv->load();

class UserService
{
    private \PDO $db;
    private Auth\Auth $auth;

    public function __construct()
    {
        $this->db = new \PDO('mysql:dbname=' . $_ENV['DB_NAME'] . ';host=' . $_ENV['DB_HOST'] . ';charset=utf8mb4', $_ENV['DB_USER'], $_ENV['DB_PASSWORD']);
        $this->auth = new Auth\Auth($this->db);
    }

    public function getUserInfo(): array
    {
        if (!$this->auth->isLoggedIn()) {
            throw new \Error('User is not logged in.');
        }

        $userId = $this->auth->getUserId();
        $userEmail = $this->auth->getEmail();
        $userName = $this->auth->getUsername();

        return [
            'id' => $userId,
            'email' => $userEmail,
            'name' => $userName,
        ];
    }

    public function changePassword(string $currentPassword, string $newPassword): void
    {
        if (!$this->auth->isLoggedIn()) {
            throw new \Error('User is not logged in.');
        }

        if (!v::length(8, 100)->validate($newPassword)) {
            throw new \Error('New password must be between 8 and 100 characters long.');
        }

        try {
            $this->auth->changePassword($currentPassword, $newPassword);
        } catch (Auth\InvalidPasswordException) {
            throw new \Error('Current password is incorrect.');
        } catch (Auth\NotLoggedInException) {
            throw new \Error('You are not logged in.');
        } catch (Auth\TooManyRequestsException) {
            throw new \Error('Too many requests. Please try again later.');
        }
    }

    public function deleteAccount(string $password): void
    {
        if (!$this->auth->isLoggedIn()) {
            throw new \Error('User is not logged in.');
        }

        try {
            if ($this->auth->reconfirmPassword($password) === false) {
                throw new \Error('Password is incorrect.');
            }

            $this->auth->admin()->deleteUserById($this->auth->getUserId());
        } catch (Auth\UnknownIdException) {
            throw new \Error('An error occurred.');
        } catch (Auth\NotLoggedInException) {
            throw new \Error('You are not logged in.');
        } catch (Auth\TooManyRequestsException) {
            throw new \Error('Too many requests. Please try again later.');
        }
    }
}