<?php

declare(strict_types=1);

namespace App\Staff\Controllers;

use App\Staff\Services\ManagementService;

class StaffController
{
    private ManagementService $managementService;

    public function __construct()
    {
        $this->managementService = new ManagementService();
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
            'pageTitle' => 'Your Settings - St. Thomas Events'
        ]);
    }
}