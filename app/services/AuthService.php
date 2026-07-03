<?php

declare(strict_types=1);

require_once __DIR__ . '/../repositories/AuthRepository.php';

use Respect\Validation\Validator as v;
class AuthService
{

    private AuthRepository $authRepository; 

    public function __construct()
    {
        $this->authRepository = new AuthRepository();
    }
    public function authenticate(string $email, string $password): array|false
    {

        if (empty($email) || empty($password)) {
            return false;
        }

        if (!v::email()->validate($email)) {
            return false;
        }

        if (!v::stringType()->length(2, 100)->validate($password)) {
            return false;
        }

        $user = $this->authRepository->findByEmail($email);

        if ($user && password_verify($password, $user['PasswordHash'])) {
            return $user;
        }

        return false;


    }
}