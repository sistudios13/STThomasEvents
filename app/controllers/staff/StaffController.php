<?php

declare(strict_types=1);

namespace App\Staff\Controllers;

use App\Staff\Services\UserService;
use App\Staff\Services\ManagementService;
use App\Services\AuthService;


class StaffController
{
    private ManagementService $managementService;
    private UserService $userService;
    private AuthService $authService;

    public function __construct()
    {
        $this->managementService = new ManagementService();
        $this->userService = new UserService();
        $this->authService = new AuthService();
    }
    public function index(): void
    {
        http_response_code(301);
        header('Location: ' . url('/staff/dashboard/'));
        exit();
    }

    public function dashboard(): void
    {
        render('staff/dashboard', 'staff', [
            'pageTitle' => 'Staff Dashboard - St. Thomas Events',
            'events' => $this->managementService->getCalendarData(),
            'upcomingEvents' => $this->managementService->getUpcomingEvents(),
            'upcomingCount' => \count($this->managementService->getUpcomingEvents())
        ]);
    }

    public function settings(): void
    {
        render('staff/settings', 'staff', [
            'pageTitle' => 'Your Settings - St. Thomas Events',
            'user' => $this->userService->getUserInfo()
        ]);
    }

    public function changePassword(): void
    {
        $currentPassword = $_POST['current_password'] ?? '';
        $newPassword = $_POST['new_password'] ?? '';
        $confirmNewPassword = $_POST['confirm_new_password'] ?? '';

        if ($newPassword !== $confirmNewPassword) {
            http_response_code(400);
            echo 'New password and confirmation do not match.';
            exit();
        }

        try {
            $this->userService->changePassword($currentPassword, $newPassword);
        } catch (\Error $e) {
            http_response_code(400);
            echo $e->getMessage();
            exit();
        }

        // add email notification for password change

        http_response_code(200);
        header('HX-Success-Message: Password changed successfully.');
    }

    public function deleteAccount(): void
    {
        $password = $_POST['password'] ?? 'y5y';

        try {
            $this->userService->deleteAccount($password);
        } catch (\Error $e) {
            http_response_code(400);
            echo $e->getMessage();
            exit();
        }

        $this->authService->logout();

        // add email notification for account deletion

        http_response_code(204);
        header('HX-Redirect: ' . url('/auth/deleted/'));
    }

    
}