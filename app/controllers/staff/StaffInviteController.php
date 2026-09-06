<?php

declare(strict_types=1);

namespace App\Staff\Controllers;

require __DIR__ . '/../../../config/helpers.php';

use App\Staff\Services\StaffInviteService;

class StaffInviteController
{
    private StaffInviteService $inviteService;

    public function __construct()
    {
        $this->inviteService = new StaffInviteService();
    }

    public function staffManage(): void
    {
        // Admin only
        if (!isAdmin()) {
            http_response_code(403);
            echo "Unauthorized";
            exit();
        }

        render('staff/staff_manage', 'staff', [
            'pageTitle' => 'Invite Staff Member - St. Thomas Events',
            'invites' => $this->inviteService->getInvites()
        ]);
    }

    public function sendInvite(): void
    {
        // Admin only
        if (!isAdmin()) {
            http_response_code(403);
            echo "Unauthorized";
            exit();
        }

        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');

        if (!$name || !$email) {
            http_response_code(400);
            echo 'Name and email are required.';
            exit();
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            http_response_code(400);
            echo 'Invalid email address.';
            exit();
        }

        try {
            $this->inviteService->createAndSendInvite($email, $name);
            header('HX-Success-Message: Invite sent successfully to ' . $email);
            exit();
        } catch (\Error $e) {
            http_response_code(400);
            echo $e->getMessage();
            exit();
        }
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
            render('staff/register_error', 'main', [
                'pageTitle' => 'Registration - St. Thomas Events',
                'error' => 'This registration link has expired or is invalid.'
            ]);
            exit();
        }

        render('staff/register_form', 'main', [
            'pageTitle' => 'Complete Registration - St. Thomas Events',
            'token' => $token,
            'name' => $invite['name'],
            'email' => $invite['email']
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

        if (strlen($password) < 8) {
            http_response_code(400);
            echo 'Password must be at least 8 characters.';
            exit();
        }

        try {
            $this->inviteService->completeInvite($token, $password);
            header('HX-Success-Message: Account created successfully!');
            header('HX-Redirect: ' . url('/auth/login/'));
            exit();
        } catch (\Error $e) {
            http_response_code(400);
            echo $e->getMessage();
            exit();
        }
    }

    public function deleteInvite(string $id): void
    {
        // Admin only
        if (!isAdmin()) {
            http_response_code(403);
            echo "Unauthorized";
            exit();
        }



        $deleted = $this->inviteService->deleteInvite(intval($id));

        if (!$deleted) {
            http_response_code(400);
            echo 'Failed to delete invite.';
            exit();
        }

        header('HX-Success-Message: Invite deleted successfully.');
        header('HX-Redirect: ' . url('/staff/manage/'));


    }
}
