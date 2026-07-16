<?php

declare(strict_types=1);

require __DIR__ . '/../../config/helpers.php';
require_once __DIR__ . '/../services/AuthService.php';

class AuthController
{   
    private AuthService $authService;

    public function __construct()
    {
        $this->authService = new AuthService();
    }

    public function login(): void
    {
        render('auth/login', 'main', [
            'pageTitle' => 'Staff Login - St. Thomas Events'
        ]);
    }

    public function authenticate(): void
    {
        $email = trim($_POST['email']) ?? '';
        $password = trim($_POST['password']) ?? '';

        try {
            $this->authService->authenticate($email, $password);
        } catch (Error $e) {
            http_response_code(401);
            echo $e->getMessage();
            exit();
        }

        redirectToUrl(url('/staff/dashboard/'));
        exit();

    }
}