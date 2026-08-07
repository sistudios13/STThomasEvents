<?php

declare(strict_types=1);

namespace App\Staff\Controllers;

use App\Staff\Services\UserService;
use App\Staff\Services\ManagementService;
use App\Services\AuthService;
use App\Services\EventService;


class StaffController
{
    private ManagementService $managementService;
    private UserService $userService;
    private AuthService $authService;
    private EventService $eventService;

    public function __construct()
    {
        $this->managementService = new ManagementService();
        // $this->userService = new UserService();
        // $this->authService = new AuthService();
        $this->eventService = new EventService();
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

    public function events(): void
    {
        render('staff/events', 'staff', [
            'pageTitle' => 'All Events - St. Thomas Events',
            'eventsData' => $this->managementService->getGroupedEvents()
        ]);
    }

    public function manageEvent($id): void
    {
        $eventData = $this->managementService->findEventById(intval($id));
        if (!$eventData) {
            http_response_code(404);
            header('Location: ' . url('/404/'));
            return;
        }

        $currentPage = 1;
        $search = '';
        $sortKey = '';
        $sortOrder = '';

        $info = $this->managementService->getInfoAndValidate(intval($id), $currentPage, $search, $sortKey, $sortOrder);
        $bookings = $this->managementService->getBookings(intval($id), $info['current_page'], $info['search'], $info['sort_key'], $info['sort_order']);

        render('staff/manage_event', 'staff', [
            'pageTitle' => 'Manage Event - St. Thomas Events',
            'id' => $id,
            'eventData' => $eventData,
            'current_page' => $info['current_page'],
            'search' => $info['search'],
            'sortKey' => $info['sort_key'],
            'sortOrder' => $info['sort_order'],
            'info' => $info,
            'bookings' => $bookings,
        ]);
    }

    public function bookingsPartial($id): void
    {
        $eventData = $this->managementService->findEventById(intval($id));
        if (!$eventData) {
            http_response_code(404);
            header('Location: ' . url('/404/'));
            return;
        }

        $currentPage = $_GET['page'] ?? 1; // dont return these. Return the valiated ones; $info
        $search = $_GET['search'] ?? '';
        $sortKey = $_GET['sort'] ?? '';
        $sortOrder = $_GET['order'] ?? '';

        try {
            $info = $this->managementService->getInfoAndValidate(intval($id), intval($currentPage), $search, $sortKey, $sortOrder);

            $bookings = $this->managementService->getBookings(intval($id), $info['current_page'], $info['search'], $info['sort_key'], $info['sort_order']);

        } catch (\InvalidArgumentException $e) {
            http_response_code(400);
            echo $e->getMessage();
            return;
        }

        $currentPage = $info['current_page'] ?? 1; //vaidated
        $search = $info['search'] ?? '';
        $sortKey = $info['sort_key'] ?? '';
        $sortOrder = $info['sort_order'] ?? '';

        require __DIR__ . '/../../views/partials/bookings.php';
    }

    public function deleteBooking($id, $bookingId): void
    {
        $eventData = $this->managementService->findEventById(intval($id));
        if (!$eventData) {
            http_response_code(404);
            redirectToUrl(url('/404/'));
            return;
        }

        try {
            $deleted = $this->managementService->deleteBooking(\intval($bookingId));
        } catch (\InvalidArgumentException $e) {
            http_response_code(400);
            echo $e->getMessage();
            return;
        }

        if (!$deleted) {
            http_response_code(404);
            echo "Booking not found or could not be deleted.";
            return;
        }

        // updated table
        $currentPage = $_GET['page'] ?? 1; // dont return these. Return the valiated ones; $info
        $search = $_GET['search'] ?? '';
        $sortKey = $_GET['sort'] ?? '';
        $sortOrder = $_GET['order'] ?? '';

        try {
            $info = $this->managementService->getInfoAndValidate(intval($id), intval($currentPage), $search, $sortKey, $sortOrder);
            $bookings = $this->managementService->getBookings(intval($id), $info['current_page'], $info['search'], $info['sort_key'], $info['sort_order']);

        } catch (\InvalidArgumentException $e) {
            http_response_code(400);
            echo $e->getMessage();
            return;
        }

        header('Hx-Success-Message: Booking deleted successfully.');

        require __DIR__ . '/../../views/partials/bookings.php';
    }

}