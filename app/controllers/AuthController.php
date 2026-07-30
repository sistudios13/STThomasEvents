<?php

declare(strict_types=1);

namespace App\Controllers;

require __DIR__ . '/../../config/helpers.php';

use App\Services\AuthService;

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
        $remember = isset($_POST['remember']) && $_POST['remember'] === 'on';

        try {
            $this->authService->authenticate($email, $password, $remember);
        } catch (\Error $e) {
            http_response_code(401);
            echo $e->getMessage();
            exit();
        }

        header('HX-Redirect: ' . url('/staff/dashboard/'));
        exit();

    }

    public function logout(): void
    {
        if (staffAuthenticated()) {
            $this->authService->logout();
        }

        header('Location: ' . url('/login/'));
        exit();
    }

    public function accountDeleted(): void
    {
        render('auth/account_deleted', null, [
            'pageTitle' => 'Account Deleted - St. Thomas Events'
        ]);
    }
}