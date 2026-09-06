<?php

declare(strict_types=1);

namespace App\Controllers;

require __DIR__ . '/../../config/helpers.php';

use App\Staff\Services\StaffInviteService;

class RegistrationController
{
    private StaffInviteService $inviteService;

    public function __construct()
    {
        $this->inviteService = new StaffInviteService();
    }

    public function showRegistrationForm(string $token): void
    {

        if (!$token) {
            http_response_code(400);
            render('staff/register_error', 'main', [
                'pageTitle' => 'Registration - St. Thomas Events',
                'error' => 'Invalid registration link.'
            ]);
            exit();
        }

        $invite = $this->inviteService->getInviteByToken($token);

        if (!$invite) {
            http_response_code(400);
            render('staff/register_error', 'no_header', [
                'pageTitle' => 'Registration - St. Thomas Events',
                'error' => 'This registration link has expired or is invalid.'
            ]);
            exit();
        }

        render('staff/register_form', 'main', [
            'pageTitle' => 'Complete Registration - St. Thomas Events',
            'token' => $token,
            'name' => $invite['Name'],
            'email' => $invite['Email']
        ]);
    }

    public function completeRegistration(): void
    {

        $token = trim($_POST['token'] ?? '');
        $password = $_POST['password'] ?? '';
        $passwordConfirm = $_POST['password_confirm'] ?? '';

        if (!$token || !$password || !$passwordConfirm) {
            http_response_code(400);
            echo 'All fields are required.';
            exit();
        }

        if ($password !== $passwordConfirm) {
            http_response_code(400);
            echo 'Passwords do not match.';
            exit();
        }

        if (strlen($password) < 8 || strlen($password) > 200) {
            http_response_code(400);
            echo 'Password must be between 8 and 200 characters.';
            exit();
        }

        try {
            $this->inviteService->completeInvite($token, $password);
            header('HX-Success-Message: Account created successfully!');
            header('HX-Redirect: ' . url('/login/'));
            exit();
        } catch (\Error $e) {
            http_response_code(400);
            echo $e->getMessage();
            exit();
        }
    }
}
