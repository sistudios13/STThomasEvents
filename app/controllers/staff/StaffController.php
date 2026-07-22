<?php

declare(strict_types=1);

namespace App\Staff\Controllers;

class StaffController
{
    public function index(): void
    {
        http_response_code(301);
        header('Location: ' . url('/staff/dashboard/'));
        exit();
    }

    public function dashboard(): void
    {
        render('staff/dashboard', 'staff', [
            'pageTitle' => 'Staff Dashboard - St. Thomas Events'
        ]);
    }

    public function settings(): void
    {
        render('staff/settings', 'staff', [
            'pageTitle' => 'Your Settings - St. Thomas Events'
        ]);
    }
}