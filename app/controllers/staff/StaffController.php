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
        $upcoming = $this->managementService->getUpcomingEvents();

        $totalBookings = 0;
        foreach ($upcoming as $event) {
            $bookingsCount = $this->managementService->getInfoAndValidate($event['Id'], 1, '', '', '');
            $totalBookings += $bookingsCount['total_rows'] ?? 0;
        }

        render('staff/dashboard', 'staff', [
            'pageTitle' => 'Staff Dashboard - St. Thomas Events',
            'events' => $this->managementService->getCalendarData(),
            'upcomingEvents' => $upcoming,
            'upcomingCount' => \count($upcoming),
            'bookingsCount' => $totalBookings
        ]);
    }

    public function events(): void
    {
        render('staff/events', 'staff', [
            'pageTitle' => 'All Events - St. Thomas Events',
            'eventsData' => $this->managementService->getGroupedEvents()
        ]);
    }

    public function manageEvent(string $id): void
    {
        $eventData = $this->managementService->findEventById(intval($id));
        if (!$eventData) {
            http_response_code(404);
            header('Location: ' . url('/404/'));
            return;
        }

        if (!$eventData['Seating']) {
            render('staff/manage_event', 'staff', [
                'pageTitle' => 'Manage Event - St. Thomas Events',
                'id' => $id,
                'eventData' => $eventData,
            ]);
            exit;
        }

        $currentPage = 1;
        $search = '';
        $sortKey = '';
        $sortOrder = '';

        $info = $this->managementService->getInfoAndValidate(intval($id), $currentPage, $search, $sortKey, $sortOrder);
        $bookings = $this->managementService->getBookings(intval($id), $info['current_page'], $info['search'], $info['sort_key'], $info['sort_order']);

        render('staff/manage_seated_event', 'staff', [
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

    public function bookingsPartial(string $id): void
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

    public function deleteBooking(string $id, string $bookingId): void
    {
        $eventData = $this->managementService->findEventById(\intval($id));
        if (!$eventData) {
            http_response_code(404);
            redirectToUrl(url('/404/'));
            return;
        }

        if (!$this->managementService->bookingExists(\intval($id), \intval($bookingId))) {
            http_response_code(404);
            echo "Booking not found.";
            return;
        }

        if ($eventData['EndsAt'] < date('Y-m-d H:i:s')) {
            http_response_code(400);
            echo "Cannot delete booking for an event that has already ended.";
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

    public function new(): void
    {

        render('staff/new_event', 'staff', [
            'pageTitle' => 'Create Event - St. Thomas Events',
        ]);
    }

    public function newEvent(): void
    {


        $name = $_POST['name'] ?? '';
        $description = $_POST['description'] ?? '';
        $starts = $_POST['starts'] ?? '';
        $ends = $_POST['ends'] ?? '';
        $pricing = $_POST['pricing'] ?? '';
        $location = $_POST['location'] ?? '';
        $seating = $_POST['seating'] ?? '';
        $seating_enabled = $seating == '1' ? 'on' : 'off';

        try {
            $eventId = $this->managementService->createEvent($name, $description, $pricing, $starts, $ends, $location, $seating_enabled);
            http_response_code(201);

            echo "
                <section id='event-created' class='w-full h-full flex flex-col text-center items-center justify-center p-4 min-h-screen'>
                    <svg class='size-18 text-indigo-600 mb-2' aria-hidden='true' xmlns='http://www.w3.org/2000/svg' width='24' height='24' fill='none' viewBox='0 0 24 24'>
                        <path stroke='currentColor' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m8.032 12 1.984 1.984 4.96-4.96m4.55 5.272.893-.893a1.984 1.984 0 0 0 0-2.806l-.893-.893a1.984 1.984 0 0 1-.581-1.403V7.04a1.984 1.984 0 0 0-1.984-1.984h-1.262a1.983 1.983 0 0 1-1.403-.581l-.893-.893a1.984 1.984 0 0 0-2.806 0l-.893.893a1.984 1.984 0 0 1-1.403.581H7.04A1.984 1.984 0 0 0 5.055 7.04v1.262c0 .527-.209 1.031-.581 1.403l-.893.893a1.984 1.984 0 0 0 0 2.806l.893.893c.372.372.581.876.581 1.403v1.262a1.984 1.984 0 0 0 1.984 1.984h1.262c.527 0 1.031.209 1.403.581l.893.893a1.984 1.984 0 0 0 2.806 0l.893-.893a1.985 1.985 0 0 1 1.403-.581h1.262a1.984 1.984 0 0 0 1.984-1.984V15.7c0-.527.209-1.031.581-1.403Z'/>
                    </svg>
                    <h2 class='text-2xl font-semibold tracking-tight text-gray-900'>Event Created Successfully</h2>
                    <p class='mt-1 text-sm text-gray-500'>The event has been created successfully. Click below to manage the event.</p>
                    <div class='mt-4 flex gap-2'>
                        <a href='" . url("/staff/events/{$eventId}/") . "' class='inline-flex items-center justify-center rounded-md border border-transparent bg-blue-600 px-4 py-2 text-sm font-medium text-white shadow-sm transition hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2'>Manage Event</a>
                    </div>
                </section>
                <script>
                    const targetElement = document.getElementById('event-created');

                // Instant scroll
                targetElement.scrollIntoView();
                </script>
                ";

            exit();
        } catch (\InvalidArgumentException $e) {
            http_response_code(400);
            echo $e->getMessage();
            return;
        }
    }

    public function edit(string $id): void
    {
        $eventData = $this->managementService->findEventById(intval($id));
        if (!$eventData) {
            http_response_code(404);
            redirectToUrl(url('/404/'));
            return;
        }

        render('staff/edit_event', 'staff', [
            'pageTitle' => 'Edit Event - St. Thomas Events',
            'id' => $id,
            'eventData' => $eventData,
        ]);
    }

    public function editEvent(string $id): void
    {
        $eventData = $this->managementService->findEventById(intval($id));
        if (!$eventData) {
            http_response_code(404);
            redirectToUrl(url('/404/'));
            return;
        }

        $name = $_POST['name'] ?? '';
        $description = $_POST['description'] ?? '';
        $starts = $_POST['starts'] ?? '';
        $ends = $_POST['ends'] ?? '';
        $pricing = $_POST['pricing'] ?? '';
        $location = $_POST['location'] ?? '';
        $seating = $_POST['seating'] ?? '';
        $seating_enabled = $seating == '1' ? 'on' : 'off';

        try {
            $this->managementService->editEvent($id, $name, $description, $pricing, $starts, $ends, $location, $seating_enabled);
            http_response_code(200);

            echo "
                <section id='event-updated' class='w-full h-full flex flex-col text-center items-center justify-center p-4 min-h-screen'>
                    <svg class='size-18 text-indigo-600 mb-2' aria-hidden='true' xmlns='http://www.w3.org/2000/svg' width='24' height='24' fill='none' viewBox='0 0 24 24'>
                        <path stroke='currentColor' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m8.032 12 1.984 1.984 4.96-4.96m4.55 5.272.893-.893a1.984 1.984 0 0 0 0-2.806l-.893-.893a1.984 1.984 0 0 1-.581-1.403V7.04a1.984 1.984 0 0 0-1.984-1.984h-1.262a1.983 1.983 0 0 1-1.403-.581l-.893-.893a1.984 1.984 0 0 0-2.806 0l-.893.893a1.984 1.984 0 0 1-1.403.581H7.04A1.984 1.984 0 0 0 5.055 7.04v1.262c0 .527-.209 1.031-.581 1.403l-.893.893a1.984 1.984 0 0 0 0 2.806l.893.893c.372.372.581.876.581 1.403v1.262a1.984 1.984 0 0 0 1.984 1.984h1.262c.527 0 1.031.209 1.403.581l.893.893a1.984 1.984 0 0 0 2.806 0l.893-.893a1.985 1.985 0 0 1 1.403-.581h1.262a1.984 1.984 0 0 0 1.984-1.984V15.7c0-.527.209-1.031.581-1.403Z'/>
                    </svg>
                    <h2 class='text-2xl font-semibold tracking-tight text-gray-900'>Event Updated Successfully</h2>
                    <p class='mt-1 text-sm text-gray-500'>The event has been updated successfully. Click below to manage the event.</p>
                    <div class='mt-4 flex gap-2'>
                        <a href='" . url("/staff/events/{$id}/") . "' class='inline-flex items-center justify-center rounded-md border border-transparent bg-blue-600 px-4 py-2 text-sm font-medium text-white shadow-sm transition hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2'>Manage Event</a>
                    </div>
                </section>
                <script>
                    const targetElement = document.getElementById('event-updated');

                // Instant scroll
                targetElement.scrollIntoView();
                </script>
                ";

            exit();
        } catch (\InvalidArgumentException $e) {
            http_response_code(400);
            echo $e->getMessage();
            return;
        }
    }

    public function deleteEvent(string $id): void
    {
        $eventData = $this->managementService->findEventById(\intval($id));
        if (!$eventData) {
            http_response_code(404);
            echo "Event not found.";
            return;
        }

        try {
            $this->managementService->deleteEvent(\intval($id));
        } catch (\InvalidArgumentException $e) {
            http_response_code(400);
            echo $e->getMessage();
            return;
        }

        http_response_code(200);
        echo "
            <section id='event-updated' class='w-full h-full flex flex-col text-center items-center justify-center p-4 min-h-screen'>
                <svg class='size-18 text-indigo-600 mb-2' aria-hidden='true' xmlns='http://www.w3.org/2000/svg' width='24' height='24' fill='none' viewBox='0 0 24 24'>
                <path stroke='currentColor' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z'/>
                </svg>

                <h2 class='text-2xl font-semibold tracking-tight text-gray-900'>Event Deleted Successfully</h2>
                <p class='mt-1 text-sm text-gray-500'>The event has been deleted successfully.</p>
                <div class='mt-4 flex gap-2'>
                    <a href='" . url("/staff/dashboard/") . "' class='inline-flex items-center justify-center rounded-md border border-transparent bg-blue-600 px-4 py-2 text-sm font-medium text-white shadow-sm transition hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2'>To Dashboard</a>
                </div>
            </section>
            <script>
                const targetElement = document.getElementById('event-updated');

            // Instant scroll
            targetElement.scrollIntoView();
            </script>
            ";

        exit();
    }

}