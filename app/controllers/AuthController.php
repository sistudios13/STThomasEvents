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

        $user = $this->authService->authenticate($email, $password);

        if (!$user) {
            http_response_code(401);
            echo 'Invalid email or password.';
            return;
        } 

        // success
        session_regenerate_id(true);
        $_SESSION['uid'] = $user['Id'];
        $_SESSION['email'] = $user['Email'];
        $_SESSION['role'] = $user['Role'];
        $_SESSION['created_at'] = time();
        $_SESSION['last_regen'] = time();

        header('HX-Redirect: ' . url('/staff/dashboard'));
        exit();

    }
}